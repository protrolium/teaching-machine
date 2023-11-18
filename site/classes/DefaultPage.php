<?php namespace ProcessWire;
class DefaultPage extends Page {
    public function init() {
        // test to see if init method is working in the Tracy Debugger Dump
        // bd("init method");

        // Call wpPost() when Page is saved to get the WP API data
        //$this->wire->addHookAfter("Pages::saveReady", $this, "wpPost");
    }
    
    public function wpPost() {
        // for more information check Tracy Debugger by logging bd($event) 
        // … argument 0 is the ProcessWire\Page
        //$page = $event->arguments(0);
        
        $pages = wire('pages');
        $config = wire('config');
        $http = new WireHttp();

        // posts endpoint
        $result = $http->get('https://network.teachingmachine.tv/wp-json/wp/v2/posts/?per_page=54');
        $result = json_decode($result);

        $templates = wire('templates');
        $parentPage = $pages->get('name=dump');
        $template = $templates->get('default-page');
        $optimizedArray = [];

        // stdObject method
        foreach ($result as $item) {
            // Create a new object using object casting
            $postObject = (object) [
                'id' => $item->id,
                'title' => $item->title->rendered,
                'date' => $item->date,
                'content' => $item->content->rendered,
                'categories' => $item->categories,
                'slug' => $item->slug,
            ];
        
            // Add the object to the optimized array
            $optimizedArray[] = $postObject;
        }

        //bd($template);
        bd($optimizedArray);

        foreach ($optimizedArray as $post) {
            // Check if a page with this wp_id already exists to avoid duplicates
            $existingPage = $pages->get("name=$post->slug, template=default_page, parent=dump");
            if ($existingPage->id) {
                continue; // Skip if page already exists
            }
            
            // bd($post);
            $newPage = new Page();
            $newPage->template = $template;
            $newPage->parent = $parentPage;
            $newPage->title = $post->title;
            $newPage->name = $post->slug;
            $newPage->post_date = $post->date;

            $newPage->save();

            // individual post endpoint via id
            $postsResult = $http->get('https://network.teachingmachine.tv/wp-json/wp/v2/posts/' . $post->id);
            $postsResult = json_decode($postsResult);

            // media endpoint
            $featuredMediId = $postsResult->featured_media;
            $featuredImageResult = $http->get('https://network.teachingmachine.tv/wp-json/wp/v2/media/' . $featuredMediId);
            $featuredImageResult = json_decode($featuredImageResult);

            //get the featured image
            $localImagePath = $config->paths->assets . 'files/' . $newPage->id . '/featured.jpg';
            $featuredImage = $http->get($featuredImageResult->guid->rendered);
            if($featuredImage) {
                // Save the image locally
                file_put_contents($localImagePath, $featuredImage);
            
                // Add the image to a ProcessWire page
                $newPage->get('featured_image')->add($localImagePath);

                // Add description to the image
                if($newPage->featured_image->count()) {
                    // Access the first image in the collection
                    $featuredImgDesc = $newPage->featured_image->first();
                
                    // Set the description for this image
                    $originalString = $featuredImageResult->caption->rendered;
                    $strippedString = strip_tags($originalString);
                    $featuredImgDesc->description = html_entity_decode($strippedString, ENT_QUOTES, 'UTF-8');
                } else {
                    echo "No image found in the featured_image field.";
                }

            } else {
                echo "Error downloading image";
            }

            //set body area
            $bodyRaw = $post->content;
            
            // strip HTML tags from the body but keep links and iframes
            $bodyStripped = strip_tags($bodyRaw, '<a><iframe>');
            
            // decode HTML entities
            $bodyDecoded = html_entity_decode($bodyStripped, ENT_QUOTES, 'UTF-8');
            $newPage->body = $bodyDecoded;
            
            // parse images out of the main body and save them to the assets/files/pageId folder
            $htmlContent = $bodyRaw;
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($htmlContent);
            libxml_clear_errors();

            $xpath = new \DOMXPath($dom);
            $images = $xpath->query('//img');

            $imageCounter = 0;

            foreach ($images as $img) {
                $srcset = $img->getAttribute('srcset');
                $sources = explode(", ", $srcset);

                $highestQualityImage = '';
                $maxWidth = 0;

                foreach ($sources as $source) {
                    list($url, $width) = explode(" ", $source);
                    $width = intval($width);

                    if ($width > $maxWidth) {
                        $highestQualityImage = $url;
                        $maxWidth = $width;
                    }
                }

                if ($highestQualityImage) {
                    $imageContent = file_get_contents($highestQualityImage);
                    $localPathGallery = $config->paths->assets . 'files/' . $newPage->id . "/" . ++$imageCounter . "_" . $maxWidth .".jpg"; // Unique filename
                    file_put_contents($localPathGallery, $imageContent);

                    // Add the image to the ProcessWire page
                    if ($newPage->gallery) {
                        $newPage->gallery->add($localPathGallery);
                    }
                }
            }

            //add the categories to the page as a tag
            foreach ($post->categories as $categoryId) {
                // Find the child page of Tags with the matching 'wp_id'
                $matchedPage = $pages->get("parent=tags, template=tag, wp_id=$categoryId");
                if ($matchedPage->id) {
                    // Add the matched page to the Page Reference field
                    $newPage->categories->add($matchedPage);
                }
            }

            // associative array method
            // foreach ($result as $item) {
            //     $optimizedArray[] = [
            //         'title' => $item->title->rendered,
            //         'date' => $item->date,
            //         'content' => $item->content->rendered,
            //         'categories' => $item->categories,
            //         'slug' => $item->slug,
            //     ];
            //

            $newPage->save();
            
            // for testing a single page
            // break; 
        }

    }
}