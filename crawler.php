<?php
	/**
	 * This is a simple PHP web crawler that allows the developer to control exactly what is
	 * parsed and indexed. This is fit for sites that the developer knows exactly the format of
	 * what he or she is crawling.
	 */

    ini_set('max_execution_time', 300); //Increase max run time so server doesnt kill it; 300 seconds = 5 mins
    
    // Include DOM Parser which can be downloaded at:
    // 		http://simplehtmldom.sourceforge.net/manual.htm
    include('simple_html_dom.php');

    // execute crawl function for google.com example
    crawlPage('http://google.com/', 5);

    /**
     * This function downloads the DOM for the given URL and parses as defined
     * by the method indexPage().
     * @param $url is a String of a full absolute URL
     * @param $depth is a integer that defines the depth in which the crawler should parse
     */
    function crawlPage($url, $depth = 5){	// by default, the depth is set to 5
        
        static $visted = array();

        // Exit if saw URL or Depth is 0
        if (isset($visted[$url]) || $depth === 0) {
            return;
        }

        // Mark current URL as seen
        $visted[$url] = true;

        // Download HTML
        $html = file_get_html($url);

        // **Do what you want with the HTML here**
        indexPage($html);

        // Get Anchor tags
        $anchors = $html->find('a');

        // Get URL's of each Anchor
        foreach ($anchors as $anchor) {
            $href = $anchor->href;  // get href

            // $href = getAbsURL($href, $url);  // check for relative urls

            // Crawl to next page
            crawlPage($href, ($depth-1));
        }

    }


    // Here is where you can utilize the HTML DOM conent
    // to index what you need out of the site.
    function indexPage($html) {
        echo $html->find('title', 0)->innertext;	// I'm echoing the title here but this is where you may
    												// want to link what you want to index into a SQL database

        // sqlQuery('INSERT INTO table .... VALUES ($title)'); 
    }


?>