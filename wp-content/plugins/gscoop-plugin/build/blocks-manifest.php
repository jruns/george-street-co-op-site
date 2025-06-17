<?php
// This file is generated. Do not modify it manually.
return array(
	'next-event' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'gscoop-plugin/next-event',
		'version' => '0.1.0',
		'title' => 'Next Event',
		'category' => 'widgets',
		'icon' => 'tickets-alt',
		'description' => 'Display the next upcoming Events Manager event.',
		'keywords' => array(
			'event',
			'upcoming',
			'next'
		),
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'usesContext' => array(
			'postId',
			'postType'
		),
		'textdomain' => 'gscoop-plugin',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	)
);
