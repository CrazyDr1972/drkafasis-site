<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Pre_Built_Sections {

  private static $categories = [
		'bas'	=> 'Basic',
		'lis'	=> 'List & Menus',
		'off'	=> 'Offer',
		'cal'	=> 'Call to action',
		'con'	=> 'Contact',
		'mis'	=> 'Misc',
	];

  private static $sections = [

    1 => [
      'title' => 'Text + image',
      'category' => 'bas',
    ],
    2 => [
      'title' => 'Image + text',
      'category' => 'bas',
    ],
    3 => [
      'title' => 'Text in columns',
      'category' => 'bas',
    ],
    4 => [
      'title' => 'Text in equal height columns',
      'category' => 'bas',
    ],
    5 => [
      'title' => 'Equal height of wraps',
      'category' => 'bas',
    ],
    6 => [
      'title' => 'Full width',
      'category' => 'bas',
    ],
    7 => [
      'title' => 'Full width with side padding',
      'category' => 'bas',
    ],
    8 => [
      'title' => 'Highlight left',
      'category' => 'bas',
    ],
    9 => [
      'title' => 'Highlight right',
      'category' => 'bas',
    ],
    10 => [
      'title' => 'List with icons',
      'category' => 'lis',
    ],
    11 => [
      'title' => 'List with images',
      'category' => 'lis',
    ],
    12 => [
      'title' => 'Feature list',
      'category' => 'lis',
    ],
    13 => [
      'title' => 'Custom list with numbers',
      'category' => 'lis',
    ],
    14 => [
      'title' => 'Custom lists',
      'category' => 'lis',
    ],
    15 => [
      'title' => 'Helper',
      'category' => 'lis',
    ],
    16 => [
      'title' => 'Accordion',
      'category' => 'lis',
    ],
    17 => [
      'title' => 'FAQ',
      'category' => 'lis',
    ],
    18 => [
      'title' => 'Menu with image',
      'category' => 'lis',
    ],
    19 => [
      'title' => 'Menu with heading on the background',
      'category' => 'lis',
    ],
    20 => [
      'title' => 'Boxes with hover',
      'category' => 'off',
    ],
    21 => [
      'title' => 'Images with description',
      'category' => 'off',
    ],
    22 => [
      'title' => 'Images with description centered',
      'category' => 'off',
    ],
    23 => [
      'title' => 'Trailer boxes with description',
      'category' => 'off',
    ],
    24 => [
      'title' => 'List with numbers',
      'category' => 'off',
    ],
    25 => [
      'title' => 'Icon boxes with prices',
      'category' => 'off',
    ],
    26 => [
      'title' => 'Zoom boxes with description',
      'category' => 'off',
    ],
    27 => [
      'title' => 'Sliding boxes',
      'category' => 'off',
    ],
    28 => [
      'title' => 'Flat boxes',
      'category' => 'off',
    ],
    29 => [
      'title' => 'Trailer boxes',
      'category' => 'off',
    ],
    30 => [
      'title' => 'Hover color',
      'category' => 'cal',
    ],
    31 => [
      'title' => 'Hover color in two columns',
      'category' => 'cal',
    ],
    32 => [
      'title' => 'Heading with text & button',
      'category' => 'cal',
    ],
    33 => [
      'title' => 'Headings with buttons',
      'category' => 'cal',
    ],
    34 => [
      'title' => 'Headings with buttons 2',
      'category' => 'cal',
    ],
    35 => [
      'title' => 'Headings with buttons 3',
      'category' => 'cal',
    ],
    36 => [
      'title' => 'Headings with buttons 4',
      'category' => 'cal',
    ],
    37 => [
      'title' => 'Headings with Quick facts',
      'category' => 'cal',
    ],
    38 => [
      'title' => 'Heading with bottom image',
      'category' => 'cal',
    ],
    39 => [
      'title' => 'Heading with Countdown',
      'category' => 'cal',
    ],
    40 => [
      'title' => 'Contact details with Map',
      'category' => 'con',
    ],
    41 => [
      'title' => 'Address and Opening hours with Map',
      'category' => 'con',
    ],
    42 => [
      'title' => 'Contact info with photo',
      'category' => 'con',
    ],
    43 => [
      'title' => 'Contact info with photo 2',
      'category' => 'con',
    ],
    44 => [
      'title' => 'Boxes with contact details',
      'category' => 'con',
    ],
    45 => [
      'title' => 'Heading with phone and address',
      'category' => 'con',
    ],
    46 => [
      'title' => 'Address and boxes with contact details',
      'category' => 'con',
    ],
    47 => [
      'title' => 'Heading and boxes with contact details',
      'category' => 'con',
    ],
    48 => [
      'title' => 'Contact box with background',
      'category' => 'con',
    ],
    49 => [
      'title' => 'Heading with contact info',
      'category' => 'con',
    ],
    50 => [
      'title' => 'Text with boxes',
      'category' => 'mis',
    ],
    51 => [
      'title' => 'Heading with text and Counters',
      'category' => 'mis',
    ],
    52 => [
      'title' => 'Image with text and stats',
      'category' => 'mis',
    ],
    53 => [
      'title' => 'Reviews',
      'category' => 'mis',
    ],
    54 => [
      'title' => 'Heading with list',
      'category' => 'mis',
    ],
    55 => [
      'title' => 'Timeline',
      'category' => 'mis',
    ],
    56 => [
      'title' => 'Heading with Quick facts',
      'category' => 'mis',
    ],
    57 => [
      'title' => 'Heading with Charts',
      'category' => 'mis',
    ],
    58 => [
      'title' => 'Heading with Progress bars',
      'category' => 'mis',
    ],
    59 => [
      'title' => 'Pricing items',
      'category' => 'mis',
    ],
  ];

  /**
   * GET sections
   */

  public static function get_sections(){

    return self::$sections;

  }

  /**
   * GET categories
   */

  public static function get_categories(){

    return self::$categories;

  }

}
