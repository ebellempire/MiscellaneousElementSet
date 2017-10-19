# Description
An Omeka plugin that adds a new element set for storing ... whatever. May be useful for developers and admins who need somewhere to store non-content metadata for individual items or collections. For example, you could add shortcodes and custom text snippets to a few specific item records, or configure a hero image or other display parameters for each collection, then use those in your theme templates. 

# Usage
Access Miscellaneous data in the usual way: 
`<?php echo metadata('item',array('Miscellaneous','Miscellaneous'));?>`
