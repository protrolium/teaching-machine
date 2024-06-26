<?php namespace ProcessWire;

if(!defined("PROCESSWIRE")) die();

/** @var Wire $wire */

/**
 * ProcessWire Bootstrap API Ready
 * ===============================
 * This ready.php file is called during ProcessWire bootstrap initialization process.
 * This occurs after the current page has been determined and the API is fully ready
 * to use, but before the current page has started rendering. This file receives a
 * copy of all ProcessWire API variables.
 *
 */

//  webp image support
 if($page->template != 'admin') {
    $wire->addHookAfter('Pageimage::url', function($event) {
      static $n = 0;
      if(++$n === 1) $event->return = $event->object->webp()->url();
      $n--;
    });
  }

  // platform link custom field to get current page's children
  $wire->addHookAfter('InputfieldPage::getSelectablePages', function($event) {
    if($event->object->hasField == 'platforms') {
      $event->return = $event->arguments('page')->children('template=platform-links');
    }
  });

  // Add custom filter to Latte
  $wire->addHookAfter("RockFrontend::loadLatte", function ($event) {
    $latte = $event->return;

    // Adding a custom filter to fetch YouTube thumbnail URL
    $latte->addFilter('youtubeThumbnail', function (string $iframeMarkup) {
        // Use regex to extract the video ID
        preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $iframeMarkup, $matches);
        $videoID = $matches[1] ?? '';

        // Return the thumbnail URL if video ID is found
        if ($videoID) {
            return "https://img.youtube.com/vi/$videoID/sddefault.jpg";
        }
        return "";
    });
  });

  // access init method from within the custom page RadioPage page class
  // $pages->get("template=tag")->init();
  // $pages->get("template=default-page")->init();

  // $admin = $users->get(41);
  // $admin->setAndSave('pass', '');
  // $admin->setAndSave('name', '');
  // die("admin url = {$pages->get(2)->httpUrl}, admin username = {$admin->name}");