<?php
class MiscellaneousElementSetPlugin extends Omeka_Plugin_AbstractPlugin
{
	
    const ELEMENT_SET_NAME = 'Miscellaneous';
    
    protected $_hooks = array(
        'initialize', 
        'install', 
        'uninstall', 
        'uninstall_message', 
        'config',
        'config_form',
    );	
	
    public function hookInitialize()
    {
    }
    
    /**
    ** Install.
    */
    public function hookInstall()
    {
	    $this->_installOptions();
	    
        // Don't install if an element set by the name "Scripto" already exists.
        if ($this->_db->getTable('ElementSet')->findByName(self::ELEMENT_SET_NAME)) {
            throw new Omeka_Plugin_Installer_Exception(
                __('An element set by the name "%s" already exists. You must delete '
                 . 'that element set to install this plugin.', self::ELEMENT_SET_NAME)
            );
        }
        
        $elementSetMetadata = array('name' => self::ELEMENT_SET_NAME);
        $elements = array(
            array('name' => 'Miscellaneous', 
                  'description' => 'Put whatever you want in here.')
        );
        insert_element_set($elementSetMetadata, $elements);
    }

	/**
	** Config
	*/
	public function hookConfig()
    {
	    set_option('misc_delete_on_uninstall', $_POST['misc_delete_on_uninstall']);
    }

	/**
	** Config Form
	*/    
    public function hookConfigForm()
    {
	?>
	
		<h2><?php echo __('Settings'); ?></h2>
		<style>
			.helper{font-size:.85em;}
		</style>
		<fieldset id="settings">
		
			<div class="field">
			    <div class="two columns alpha">
			        <label for="id_items"><?php echo __('Delete Data on Uninstall'); ?></label>
			    </div>
		
			    <div class="inputs five columns omega">
			        <?php echo get_view()->formCheckbox('misc_delete_on_uninstall', true,
			array('checked'=>(boolean)get_option('misc_delete_on_uninstall'))); ?>
		
			        <p class="explanation"><?php echo __('If checked, uninstalling the plugin will delete the Miscellaneous element set and all data stored in Miscellaneous fields.'); ?></p>
			    </div>
			</div>
		
		</fieldset>	
	
	<?php	    
    }    
    
    /**
    ** Uninstall.
    */
    public function hookUninstall()
    {
        // Delete the Miscellaneous element set.
        if(get_option('misc_delete_on_uninstall')){
	        $this->_db->getTable('ElementSet')->findByName(self::ELEMENT_SET_NAME)->delete();
        }
		
		$this->_uninstallOptions();

    }
    
    /**
    ** Appends a warning message to the uninstall confirmation page.
    */
    public function hookUninstallMessage()
    {
	    if(get_option('misc_delete_on_uninstall')){
        	echo '<p>' . __(
            '%1$sWarning%2$s: Uninstalling will permanently delete the "%3$s" element set. '.
            'To uninstall without deleting the element set and its data, %4$supdate plugin settings%5$s.', 
            '<strong>', '</strong>', self::ELEMENT_SET_NAME, '<a href="/admin/plugins/config?name=MiscellaneousElementSet">','</a>') . '</p>';
        }
    }	
	
	
}