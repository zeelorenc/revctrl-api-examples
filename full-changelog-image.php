<?php
// Basic PHP script which shows the 5 (default) most recent revisions to a particular project as an image.
// RevCTRL (c) 2015 - forked from https://github.com/RevCTRL-Team/API-Examples

// This page creates an image
header("Content-Type: image/png");

if(!isset($_GET['id']))
    die('No ID specified!');

// Fetch data through the RevCTRL api
$projectId = $_GET['id']; // The RevCTRL app project id
$jsonData = json_decode(file_get_contents('https://www.revctrl.com/api/changelog/' . $projectId), true);

// State the revision type
$revisionType = [
    'added     ',
    'removed   ',
    'changed   ',
    'fixed     '
];

// How many revisions should we show on the image?
$revisionLimit = count($jsonData['revisions']);

// Create the image and tailor the height to the number of revisions
// If your revisions are lengthy, increase the width or modify the whole code
$im = @imagecreate(780, 12 * $revisionLimit + 2);

// Make the background white and afterwards transparent
$background_color = imagecolorallocate($im, 255, 255, 255);
imagecolortransparent($im, $background_color);

// Text color is by default black
$text_color = imagecolorallocate($im, 0, 0, 0);

// State the project name, version and how many revisions there are
//imagestring($im, 2, 5, 5,  'Latest version for ' . $jsonData['project'] . ' is ' . $jsonData['current_version'] . '. Here\'s the ' . $revisionLimit . ' most recent revisions:', $text_color);

// Loop through every single revision that is the latest.
foreach($jsonData['revisions'] as $id => $key)
{
    imagestring($im, 2, 2, 12 * $id, $revisionType[$key['type']] . html_entity_decode(strip_tags($key['revision'])), $text_color);

    // Only want to show five results, the below can be removed optionally
    if($id > $revisionLimit)
        break;
}

// Create and destroy image
imagepng($im);
imagedestroy($im);
?>
