<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
function update_item_additional_info($item_stock_id, $item_bin_num, $item_prime_supp, 
	$item_prime_supp_no, $item_alternative_part_no, $item_manu_part_no, 
	$item_start_date, $item_custom_one, $item_custom_two, $item_custom_three, 
	$item_custom_four)
{
	$sql = "UPDATE ".TB_PREF."addfields_item SET 
		item_stock_id=".db_escape($item_stock_id).",
		item_bin_num=".db_escape($item_bin_num).",
		item_prime_supp=".db_escape($item_prime_supp).",
		item_prime_supp_no=".db_escape($item_prime_supp_no).",
		item_alternative_part_no=".db_escape($item_alternative_part_no).",
		item_manu_part_no=".db_escape($item_manu_part_no).",
		item_start_date=".db_escape($item_start_date).",
		item_custom_one=".db_escape($item_custom_one).",
		item_custom_two=".db_escape($item_custom_two).",
		item_custom_three=".db_escape($item_custom_three).",
		item_custom_four=".db_escape($item_custom_four);

	$sql .= " WHERE item_stock_id=".db_escape($item_stock_id);

	db_query($sql, "The item could not be updated");

}

function add_item_additional_info($item_stock_id, $item_bin_num, $item_prime_supp, 
	$item_prime_supp_no, $item_alternative_part_no, $item_manu_part_no, 
	$item_start_date, $item_custom_one, $item_custom_two, $item_custom_three, 
	$item_custom_four)
{
	$sql = "INSERT INTO ".TB_PREF."addfields_item (item_stock_id, item_bin_num, 
		item_prime_supp, item_prime_supp_no, item_alternative_part_no, 
		item_manu_part_no, item_start_date, item_custom_one, item_custom_two, 
		item_custom_three, item_custom_four)
		VALUES (".db_escape($item_stock_id).", ".db_escape($item_bin_num).", ".db_escape($item_prime_supp).",
		".db_escape($item_prime_supp_no).", ".db_escape($item_alternative_part_no).", "
		.db_escape($item_manu_part_no).", ".db_escape($item_start_date)
		.", ".db_escape($item_custom_one).",".db_escape($item_custom_two)
		.", ".db_escape($item_custom_three).", "
		.db_escape($item_custom_four).")";

	db_query($sql, "The item could not be added");
}

// function delete_item_NNN($stock_id)
// {
// 	$sql="DELETE FROM ".TB_PREF."stock_master WHERE stock_id=".db_escape($stock_id);
// 	db_query($sql, "could not delete stock item");

// 	/*and cascade deletes in loc_stock */
// 	$sql ="DELETE FROM ".TB_PREF."loc_stock WHERE stock_id=".db_escape($stock_id);
// 	db_query($sql, "could not delete stock item loc stock");

// 	/*and cascade deletes in purch_data */
// 	$sql ="DELETE FROM ".TB_PREF."purch_data WHERE stock_id=".db_escape($stock_id);
// 	db_query($sql, "could not delete stock item purch data");

// 	/*and cascade deletes in prices */
// 	$sql ="DELETE FROM ".TB_PREF."prices WHERE stock_id=".db_escape($stock_id);
// 	db_query($sql, "could not delete stock item prices");

// 	/*and cascade delete the bill of material if any */
// 	$sql = "DELETE FROM ".TB_PREF."bom WHERE parent=".db_escape($stock_id);
// 	db_query($sql, "could not delete stock item bom");

// 	delete_item_kit($stock_id);
// }

function get_item_additional_info($stock_id)
{
	$sql = "SELECT * FROM ".TB_PREF."addfields_item WHERE item_stock_id=".db_escape($stock_id);

	$result = db_query($sql, "could not get customer additonal info");

	return db_fetch($result);
}

function get_item_bin_no($stock_id)
{
	$sql = "SELECT item_bin_num FROM ".TB_PREF."addfields_item WHERE item_stock_id=".db_escape($stock_id);

	$result = db_query($sql, "could not get customer additonal info");

	return db_fetch($result);
}
// function get_item_additional_info($stock_id)
// {
// 	$sql = "SELECT item.*, taxtype.name AS tax_type_name
// 		FROM ".TB_PREF."stock_master item,"
// 			.TB_PREF."item_tax_types taxtype
// 		WHERE taxtype.id=item.tax_type_id
// 		AND stock_id=".db_escape($stock_id);
// 	$result = db_query($sql,"an item could not be retreived");

// 	return db_fetch($result);
// }
// function stock_items_list_existing_data($name, $selected_id=null, $all_option=false, 
// 	$submit_on_change=false, $opts=array(), $editkey = false, $type = "stock")
// {
// 	$sql = "SELECT stock_id, s.description, c.description, s.inactive, s.editable
// 			FROM ".TB_PREF."stock_master s,".TB_PREF."stock_category c WHERE s.category_id=c.category_id";

// 	// if (isset($opts['fixed_asset']) && $opts['fixed_asset'])
// 	// 	$sql .= " AND mb_flag='F'";
// 	// else
// 	// 	$sql .= " AND mb_flag!='F'";

// 	if ($editkey)
// 		set_editor('item', $name, $editkey);

// 	$ret = combo_input($name, $selected_id, $sql, 'stock_id', 's.description',
// 		array_merge(
// 		  array(
// 			'format' => '_format_stock_items',
// 			'spec_option' => $all_option===true ?  _("All Items") : $all_option,
// 			'spec_id' => ALL_TEXT,
// 			'search_box' => true,
// 			'search' => array("stock_id", "c.description","s.description"),
// 			'search_submit' => get_company_pref('no_item_list')!=0 && (!isset($opts['fixed_asset']) || !$opts['fixed_asset']),
// 			'size'=>10,
// 			'select_submit'=> $submit_on_change,
// 			'category' => 2,
// 			'order' => array('c.description','stock_id'),
// 			'editlink' => $editkey ? add_edit_combo('item') : false,
// 			'editable' => false,
// 			'max' => 255
// 		  ), $opts), $type );
// 	return $ret;
// }

// function stock_items_list_cells_existing_data($label, $name, $selected_id=null, $all_option=false, 
// 	$submit_on_change=false, $all=false, $editkey = false, $opts= array())
// {
// 	if (isset($opts['fixed_asset']) && $opts['fixed_asset'])
// 		$editor_item = 'fa_item';
// 	else
// 		$editor_item = 'item';

// // 	if ($editkey) ??
// //		set_editor($editor_item, $name, $editkey);

// 	if ($label != null)
// 		echo "<td>$label</td>\n";

// // ??
// //  $opts = array_merge($options, array('cells'=>true, 'show_inactive'=>$all, 'new_icon' => $editkey ? 'item' : false));
// //
// //	echo stock_items_list($name, $selected_id, $all_option, $submit_on_change, $opts);

// 	echo stock_items_list_existing_data($name, $selected_id, $all_option, $submit_on_change,
// 		array_merge(array('cells'=>true, 'show_inactive'=>$all), $opts), $editkey);

// }
// function get_items_NNN($fixed_asset = 0)
// {
// 	$sql = "SELECT * FROM ".TB_PREF."stock_master WHERE fixed_asset=".db_escape($fixed_asset);
// 	return db_query($sql,"items could not be retreived");
// }

// function item_in_foreign_codes_NNN($stock_id)
// {
// 	$sqls=  array(
// 	"SELECT COUNT(*) FROM "
// 		.TB_PREF."stock_moves WHERE stock_id=".db_escape($stock_id) =>
// 	 _('Cannot delete this item because there are stock movements that refer to this item.'),
// 	"SELECT COUNT(*) FROM "
// 		.TB_PREF."bom WHERE component=".db_escape($stock_id)=>
// 	 _('Cannot delete this item record because there are bills of material that require this part as a component.'),
// 	"SELECT COUNT(*) FROM "
// 		.TB_PREF."sales_order_details WHERE stk_code=".db_escape($stock_id) =>
// 	 _('Cannot delete this item because there are existing sales order items for it.'),
// 	"SELECT COUNT(*) FROM "
// 		.TB_PREF."purch_order_details WHERE item_code=".db_escape($stock_id)=>
// 	 _('Cannot delete this item because there are existing purchase order items for it.')
// 	);

// 	$msg = '';

// 	foreach($sqls as $sql=>$err) {
// 		$result = db_query($sql, "could not query stock usage");
// 		$myrow = db_fetch_row($result);
// 		if ($myrow[0] > 0) 
// 		{
// 			$msg = $err; break;
// 		}
// 	}
// 	if ($msg == '') {

// 		$kits = get_where_used($stock_id);
// 		$num_kits = db_num_rows($kits);
// 		if ($num_kits) {
// 			$msg = _("This item cannot be deleted because some code aliases 
// 				or foreign codes was entered for it, or there are kits defined 
// 				using this item as component")
// 				.':<br>';

// 			while($num_kits--) {
// 				$kit = db_fetch($kits);
// 				$msg .= "'".$kit[0]."'";
// 				if ($num_kits) $msg .= ',';
// 			}

// 		}
// 	}
// 	return $msg;
// }

// function get_items_search_NNN($description, $type)
// {
// 	global $SysPrefs;

// 	$sql = "SELECT COUNT(i.item_code) AS kit, i.item_code, i.description, c.description category
// 		FROM ".TB_PREF."stock_master s, ".TB_PREF."item_codes i
// 			LEFT JOIN ".TB_PREF."stock_category c ON i.category_id=c.category_id
// 		WHERE i.stock_id=s.stock_id
// 			AND !i.inactive AND !s.inactive
// 			AND (  i.item_code LIKE " . db_escape("%" . $description. "%") . " OR 
// 				i.description LIKE " . db_escape("%" . get_post("description"). "%") . " OR 
// 				c.description LIKE " . db_escape("%" . get_post("description"). "%") . ") ";

// 	switch ($type) {
// 		case "sales":
// 			$sql .= " AND !s.no_sale AND mb_flag <> 'F'";
// 			break;
// 		case "manufactured":
// 			$sql .= " AND mb_flag = 'M'";
// 			break;
//     	case "purchasable":
//     		$sql .= " AND NOT no_purchase AND mb_flag <> 'F' AND i.item_code=i.stock_id";
//     		break;
// 		case "costable":
// 			$sql .= " AND mb_flag <> 'D' AND mb_flag <> 'F' AND  i.item_code=i.stock_id";
// 			break;
// 		case "component":
// 			$parent = $_GET['parent'];
// 			$sql .= " AND  i.item_code=i.stock_id AND i.stock_id <> '$parent' AND mb_flag <> 'F' ";
// 			break;
// 		case "kits":
// 			$sql .= " AND !i.is_foreign AND i.item_code!=i.stock_id AND mb_flag <> 'F'";
// 			break;
// 		case "all":
// 			$sql .= " AND mb_flag <> 'F' AND i.item_code=i.stock_id";
// 			break;
// 	}

// 	if (isset($SysPrefs->max_rows_in_search))
// 		$limit = $SysPrefs->max_rows_in_search;
// 	else
// 		$limit = 10;

// 	$sql .= " GROUP BY i.item_code ORDER BY i.description LIMIT 0,".(int)($limit);

// 	return db_query($sql, "Failed in retreiving item list.");
// }

