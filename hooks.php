<?php
/**********************************************************************
    Released under the terms of the GNU General Public License, GPL, 
    as published by the Free Software Foundation, either version 3 
    of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.

    ================================================================
    Front Additional Fields
    ================================================================
    
***********************************************************************/

define('SS_ADDFLD',  142<<8); // transactions



class additional_fields_app extends application {
    
    function __construct() {
        
        parent::__construct('AddFields', _($this->help_context = 'Additional Fields'));
        $this->add_module(_("Transactions"));
        $this->add_module(_("Inquiries and Reports"));
        $this->add_module(_('Maintenance'));
        $this->add_lapp_function(2, _('Customer Custom Field Labels'), '/modules/additional_fields/manage/cust_customer_labels.php?', 'SA_SALESGROUP', MENU_MAINTENANCE);
        $this->add_lapp_function(2, _('Supplier Custom Field Labels'), '/modules/additional_fields/manage/cust_supplier_labels.php?', 'SA_SALESGROUP', MENU_MAINTENANCE);
        $this->add_lapp_function(2, _('Item Custom Field Labels'), '/modules/additional_fields/manage/cust_item_labels.php?', 'SA_SALESGROUP', MENU_MAINTENANCE);
        $this->add_lapp_function(2, _('Manage Document Types'), '/modules/additional_fields/manage/document_types.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_lapp_function(2, _('Manage Beneficiary Classes'), '/modules/additional_fields/manage/customer_class.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _('Manage Countries'),  '/modules/additional_fields/manage/country.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _('Manage Departments'), '/modules/additional_fields/manage/department_add_info.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _('Manage Cities'), '/modules/additional_fields/manage/city_add_info.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _('Manage Sectors'), '/modules/additional_fields/manage/sectors_add_info.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_extensions();
    }
    
}

class hooks_additional_fields extends hooks {

    function install_options($app) {
        global $path_to_root;
        $module_relative_path = 'modules/' . $this->module_name . '/';
        switch($app->id) {
            case 'orders':
                $app->enabled = true;
                $app->modules[2]->lappfunctions[0] = new app_function(
                    _("Add and Manage &Customers"), $module_relative_path.'manage/customers.php?',
                    'SA_CUSTOMER',
                    MENU_ENTRY
                );
                $this->remove_menu_item($app->modules[1]->lappfunctions, 1);
                break;
            case 'AP':
                $app->enabled = true;
                $app->modules[2]->lappfunctions[0] = new app_function(
                    _("&Suppliers"), $module_relative_path.'manage/suppliers.php?',
                    'SA_SUPPLIER', MENU_ENTRY
                );
                $this->remove_menu_item($app->modules[1]->lappfunctions, 1);
                break;
            case 'stock':
                $app->enabled = true;
                $app->modules[2]->lappfunctions[0] = new app_function(
                    _("&Items"), $module_relative_path.'manage/items.php?',
                    'SA_ITEM', MENU_ENTRY
                );
                $this->remove_menu_item($app->modules[1]->lappfunctions, 1);
                break;
        }
    }

    function __construct() {
        $this->module_name = 'additional_fields';
 	}
    
    function install_tabs($app) {
        $app->add_application(new additional_fields_app);
    }
    
    function install_access() {$security_sections[SS_ADDFLD] =  _("Additional Fields");
        $security_areas['SA_XFLD'] = array(SS_ADDFLD|1, _("AddFields entry"));
        return array($security_areas, $security_sections);
    }

    function activate_extension($company, $check_only=true) {
        global $db_connections;
        
        $updates = array( 'update.sql' => array('frontadd'));
 
        return $this->update_databases($company, $updates, $check_only);
    }
	
    function deactivate_extension($company, $check_only=true) {
        global $db_connections;

        $updates = array('remove.sql' => array('frontadd'));

        return $this->update_databases($company, $updates, $check_only);
    }

    function remove_menu_item(&$items, $offset) {
        array_splice($items, $offset, 1);
    }

}