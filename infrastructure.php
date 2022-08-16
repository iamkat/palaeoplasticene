<?php
// -----------------------------------------------
// FUNCTIONS
// -----------------------------------------------

// Function to generate a shortname (slug) from a string (e. g. catgeory title)
function categorySlug($name) {
    $slug = trim($name);
    $slug = preg_replace('/\s+/', '', $slug);
    $slug = strtolower($slug);
    return $slug;
}
?>