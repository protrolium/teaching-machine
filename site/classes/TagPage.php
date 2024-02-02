<?php namespace ProcessWire;
/* 
    class TagPage extends Page {
    public function init() {
        // test to see if init method is working in the Tracy Debugger Dump
        // bd("init method");

        // Call wpPost() when Page is saved to get the WP API data
        //$this->wire->addHookAfter("Pages::added", $this, "wpCategory");
    }
    
    public function wpCategory() {
        // call this function in the Tracy Debugger console to create new pages and auto-populate the fields like so:
        // > $tagPage = new TagPage();
        // > $tagPage->wpCategory();

        $pages = wire('pages');
        $templates = wire('templates');
        $parentPage = $pages->get('name=tags');
        $template = $templates->get('tag');
        $http = new WireHttp();
        
        // Fetch categories from WordPress
        $categoryResult = $http->get('https://network.teachingmachine.tv/wp-json/wp/v2/categories/?per_page=60');
        $categoryResult = json_decode($categoryResult);

        $categoriesArrayFromWP = $categoryResult;
        $optimizedArray = [];

        foreach ($categoriesArrayFromWP as $item) {
            $optimizedArray[] = [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
            ];
        }

        // transform into associative array
        $categoriesMap = [];
        foreach ($optimizedArray as $category) {
            $categoriesMap[$category['id']] = $category['name'];
        }

        bd($categoriesMap);

        if(!$parentPage->id) {
            throw new WireException("Parent page does not exist");
        }
        if(!$template) {
            throw new WireException("Template does not exist");
        }

        foreach ($categoriesMap as $wpId => $title) {
            // Check if a page with this wp_id already exists to avoid duplicates
            $existingPage = $pages->get("wp_id=$wpId, template=tag");
            if ($existingPage->id) {
                continue; // Skip if page already exists
            }

            $newPage = new Page();
            $newPage->template = $template;
            $newPage->parent = $parentPage;
            $newPage->title = $title;
            $newPage->wp_id = $wpId;

            $newPage->save();
        }
    
    }    

}
*/

