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

class add_fields_sales_app extends application {
    
    function __construct() {
        global $path_to_root;
        
        parent::__construct('orders', _($this->help_context = '&Sales'));
        
        $this->add_module(_("Transactions"));
        $this->add_lapp_function(0, _("Sales &Quotation Entry"),
            "sales/sales_order_entry.php?NewQuotation=Yes", 'SA_SALESQUOTE', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("Sales &Order Entry"),
            "sales/sales_order_entry.php?NewOrder=Yes", 'SA_SALESORDER', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("Direct &Delivery"),
            "sales/sales_order_entry.php?NewDelivery=0", 'SA_SALESDELIVERY', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("Direct &Invoice"),
            "sales/sales_order_entry.php?NewInvoice=0", 'SA_SALESINVOICE', MENU_TRANSACTION);
        $this->add_lapp_function(0, "","");
        $this->add_lapp_function(0, _("&Delivery Against Sales Orders"),
            "sales/inquiry/sales_orders_view.php?OutstandingOnly=1", 'SA_SALESDELIVERY', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("&Invoice Against Sales Delivery"),
            "sales/inquiry/sales_deliveries_view.php?OutstandingOnly=1", 'SA_SALESINVOICE', MENU_TRANSACTION);

        $this->add_rapp_function(0, _("&Template Delivery"),
            "sales/inquiry/sales_orders_view.php?DeliveryTemplates=Yes", 'SA_SALESDELIVERY', MENU_TRANSACTION);
        $this->add_rapp_function(0, _("&Template Invoice"),
            "sales/inquiry/sales_orders_view.php?InvoiceTemplates=Yes", 'SA_SALESINVOICE', MENU_TRANSACTION);
        $this->add_rapp_function(0, _("&Create and Print Recurrent Invoices"),
            "sales/create_recurrent_invoices.php?", 'SA_SALESINVOICE', MENU_TRANSACTION);
        $this->add_rapp_function(0, "","");
        $this->add_rapp_function(0, _("Customer &Payments"),
            "sales/customer_payments.php?", 'SA_SALESPAYMNT', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("Invoice &Prepaid Orders"),
            "sales/inquiry/sales_orders_view.php?PrepaidOrders=Yes", 'SA_SALESINVOICE', MENU_TRANSACTION);
        $this->add_rapp_function(0, _("Customer &Credit Notes"),
            "sales/credit_note_entry.php?NewCredit=Yes", 'SA_SALESCREDIT', MENU_TRANSACTION);
        $this->add_rapp_function(0, _("&Allocate Customer Payments or Credit Notes"),
            "sales/allocations/customer_allocation_main.php?", 'SA_SALESALLOC', MENU_TRANSACTION);

        $this->add_module(_("Inquiries and Reports"));
        $this->add_lapp_function(1, _("Sales Quotation I&nquiry"),
            "sales/inquiry/sales_orders_view.php?type=32", 'SA_SALESTRANSVIEW', MENU_INQUIRY);
        $this->add_lapp_function(1, _("Sales Order &Inquiry"),
            "sales/inquiry/sales_orders_view.php?type=30", 'SA_SALESTRANSVIEW', MENU_INQUIRY);
        $this->add_lapp_function(1, _("Customer Transaction &Inquiry"),
            "sales/inquiry/customer_inquiry.php?", 'SA_SALESTRANSVIEW', MENU_INQUIRY);
        $this->add_lapp_function(1, _("Customer Allocation &Inquiry"),
            "sales/inquiry/customer_allocation_inquiry.php?", 'SA_SALESALLOC', MENU_INQUIRY);

        $this->add_rapp_function(1, _("Customer and Sales &Reports"),
            "reporting/reports_main.php?Class=0", 'SA_SALESTRANSVIEW', MENU_REPORT);

        $this->add_module(_("Maintenance"));
        $this->add_lapp_function(2, _("Add and Manage &Customers"),
            "/modules/additional_fields/manage/add_customers.php?", 'SA_CUSTOMER', MENU_ENTRY);
        $this->add_lapp_function(2, _("Customer &Branches"),
            "sales/manage/customer_branches.php?", 'SA_CUSTOMER', MENU_ENTRY);
        $this->add_lapp_function(2, _("Sales &Groups"),
            "sales/manage/sales_groups.php?", 'SA_SALESGROUP', MENU_MAINTENANCE);
        $this->add_lapp_function(2, _("Recurrent &Invoices"),
            "sales/manage/recurrent_invoices.php?", 'SA_SRECURRENT', MENU_MAINTENANCE);

        $this->add_rapp_function(2, _("Sales T&ypes"),
            "sales/manage/sales_types.php?", 'SA_SALESTYPES', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _("Sales &Persons"),
            "sales/manage/sales_people.php?", 'SA_SALESMAN', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _("Sales &Areas"),
            "sales/manage/sales_areas.php?", 'SA_SALESAREA', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _("Credit &Status Setup"),
            "sales/manage/credit_status.php?", 'SA_CRSTATUS', MENU_MAINTENANCE);
        $this->add_extensions();
    }
}

class add_fields_supp_app extends application {
	
    function __construct() {
        global $path_to_root;
        
        parent::__construct('AP', _($this->help_context = '&Purchases'));
        
        $this->add_module(_("Transactions"));
        $this->add_lapp_function(0, _("Purchase &Order Entry"),
            "purchasing/po_entry_items.php?NewOrder=Yes", 'SA_PURCHASEORDER', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("&Outstanding Purchase Orders Maintenance"),
            "purchasing/inquiry/po_search.php?", 'SA_GRN', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("Direct &GRN"),
            "purchasing/po_entry_items.php?NewGRN=Yes", 'SA_GRN', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("Direct Supplier &Invoice"),
            "purchasing/po_entry_items.php?NewInvoice=Yes", 'SA_SUPPLIERINVOICE', MENU_TRANSACTION);

        $this->add_rapp_function(0, _("&Payments to Suppliers"),
            "purchasing/supplier_payment.php?", 'SA_SUPPLIERPAYMNT', MENU_TRANSACTION);
        $this->add_rapp_function(0, "","");
        $this->add_rapp_function(0, _("Supplier &Invoices"),
            "purchasing/supplier_invoice.php?New=1", 'SA_SUPPLIERINVOICE', MENU_TRANSACTION);
        $this->add_rapp_function(0, _("Supplier &Credit Notes"),
            "purchasing/supplier_credit.php?New=1", 'SA_SUPPLIERCREDIT', MENU_TRANSACTION);
        $this->add_rapp_function(0, _("&Allocate Supplier Payments or Credit Notes"),
            "purchasing/allocations/supplier_allocation_main.php?", 'SA_SUPPLIERALLOC', MENU_TRANSACTION);

        $this->add_module(_("Inquiries and Reports"));
        $this->add_lapp_function(1, _("Purchase Orders &Inquiry"),
            "purchasing/inquiry/po_search_completed.php?", 'SA_SUPPTRANSVIEW', MENU_INQUIRY);
        $this->add_lapp_function(1, _("Supplier Transaction &Inquiry"),
            "purchasing/inquiry/supplier_inquiry.php?", 'SA_SUPPTRANSVIEW', MENU_INQUIRY);
        $this->add_lapp_function(1, _("Supplier Allocation &Inquiry"),
            "purchasing/inquiry/supplier_allocation_inquiry.php?", 'SA_SUPPLIERALLOC', MENU_INQUIRY);

        $this->add_rapp_function(1, _("Supplier and Purchasing &Reports"),
            "reporting/reports_main.php?Class=1", 'SA_SUPPTRANSVIEW', MENU_REPORT);

        $this->add_module(_("Maintenance"));
        $this->add_lapp_function(2, _("&Suppliers"),
            "/modules/additional_fields/manage/add_suppliers.php?", 'SA_SUPPLIER', MENU_ENTRY);
		$this->add_extensions();
    }
}

class add_fields_item_app extends application {
    
    function __construct() {
        global $path_to_root;
        
        parent::__construct('stock', _($this->help_context = '&Items and Inventory'));
        
        $this->add_module(_("Transactions"));
        $this->add_lapp_function(0, _("Inventory Location &Transfers"),
            "inventory/transfers.php?NewTransfer=1", 'SA_LOCATIONTRANSFER', MENU_TRANSACTION);
        $this->add_lapp_function(0, _("Inventory &Adjustments"),
            "inventory/adjustments.php?NewAdjustment=1", 'SA_INVENTORYADJUSTMENT', MENU_TRANSACTION);

        $this->add_module(_("Inquiries and Reports"));
        $this->add_lapp_function(1, _("Inventory Item &Movements"),
            "inventory/inquiry/stock_movements.php?", 'SA_ITEMSTRANSVIEW', MENU_INQUIRY);
        $this->add_lapp_function(1, _("Inventory Item &Status"),
            "inventory/inquiry/stock_status.php?", 'SA_ITEMSSTATVIEW', MENU_INQUIRY);
        $this->add_rapp_function(1, _("Inventory &Reports"),
            "reporting/reports_main.php?Class=2", 'SA_ITEMSTRANSVIEW', MENU_REPORT);

        $this->add_module(_("Maintenance"));
        $this->add_lapp_function(2, _("&Items"),
            "/modules/additional_fields/manage/add_items.php?", 'SA_ITEM', MENU_ENTRY);
        $this->add_lapp_function(2, _("&Foreign Item Codes"),
            "inventory/manage/item_codes.php?", 'SA_FORITEMCODE', MENU_MAINTENANCE);
        $this->add_lapp_function(2, _("Sales &Kits"),
            "inventory/manage/sales_kits.php?", 'SA_SALESKIT', MENU_MAINTENANCE);
        $this->add_lapp_function(2, _("Item &Categories"),
            "inventory/manage/item_categories.php?", 'SA_ITEMCATEGORY', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _("Inventory &Locations"),
            "inventory/manage/locations.php?", 'SA_INVENTORYLOCATION', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _("&Units of Measure"),
            "inventory/manage/item_units.php?", 'SA_UOM', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _("&Reorder Levels"),
            "inventory/reorder_level.php?", 'SA_REORDER', MENU_MAINTENANCE);

        $this->add_module(_("Pricing and Costs"));
        $this->add_lapp_function(3, _("Sales &Pricing"),
            "inventory/prices.php?", 'SA_SALESPRICE', MENU_MAINTENANCE);
        $this->add_lapp_function(3, _("Purchasing &Pricing"),
            "inventory/purchasing_data.php?", 'SA_PURCHASEPRICING', MENU_MAINTENANCE);
        $this->add_rapp_function(3, _("Standard &Costs"),
            "inventory/cost_update.php?", 'SA_STANDARDCOST', MENU_MAINTENANCE);
        $this->add_extensions();
    }
}

class additional_fields_app extends application {
    
    function __construct() {
        global $path_to_root;
        
        parent::__construct('AddFields', _($this->help_context = 'Additional Fields'));
        
        $this->add_module(_('Maintenance'));
        $this->add_lapp_function(2, _('Manage Document Types'), $path_to_root.'/modules/additional_fields/manage/document_types.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_lapp_function(2, _('Manage Beneficiary Classes'), $path_to_root.'/modules/additional_fields/manage/customer_class.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _('Manage Countries'), '/modules/additional_fields/manage/country.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _('Manage Departments'), $path_to_root.'/modules/additional_fields/manage/department_add_info.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _('Manage Cities'), $path_to_root.'/modules/additional_fields/manage/city_add_info.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_rapp_function(2, _('Manage Sectors'), $path_to_root.'/modules/additional_fields/manage/sectors_add_info.php?', 'SA_SUPPLIER', MENU_MAINTENANCE);
        $this->add_extensions();
    }
}

class hooks_additional_fields extends hooks {
    function __construct() {
 		$this->module_name = 'add_fields_sales';
        $this->module_name = 'add_fields_supp';
        $this->module_name = 'add_fields_item';
        $this->module_name = 'additional_fields';
 	}
    
    function install_tabs($app) {
        $app->add_application(new add_fields_sales_app);
        $app->add_application(new add_fields_supp_app);
        $app->add_application(new add_fields_item_app);
        $app->add_application(new additional_fields_app);
    }
    
    function install_access() {$security_sections[SS_ADDFLD_C] =  _("Additional Fields Configuration");
        $security_sections[SS_ADDFLD] =  _("Additional Transactions");
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
}