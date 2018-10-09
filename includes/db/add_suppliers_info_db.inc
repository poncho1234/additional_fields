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

function add_supplier_additional_info($supp_supplier_id, $supp_city, $supp_department, $supp_country, 
	$supp_postcode, $supp_doc_type, $supp_valid_digit, $supp_start_date, $supp_sector, $supp_class, $supp_custom_one, 
	$supp_custom_two, $supp_custom_three, $supp_custom_four)
{
	$date = date2sql($supp_start_date);
	$sql = "INSERT INTO ".TB_PREF."addfields_supp (supp_supplier_id, supp_city, supp_department, 
		supp_country, supp_postcode, supp_doc_type, supp_valid_digit, supp_start_date, supp_sector, supp_class, 
		supp_custom_one, supp_custom_two, supp_custom_three, supp_custom_four) VALUES (".db_escape($supp_supplier_id) .", "
		.db_escape($supp_city) .", "
		.db_escape($supp_department) . ", "
		.db_escape($supp_country) . ","
		.db_escape($supp_postcode) . ", " 
		.db_escape($supp_doc_type) . ", "
		.db_escape($supp_valid_digit) . ", "
		.db_escape($supp_start_date) . ", "
		.db_escape($supp_sector) . ", "
		.db_escape($supp_class) . ", "
		.db_escape($supp_custom_one) . ", "
		.db_escape($supp_custom_two) . ", "
		.db_escape($supp_custom_three) .", "
		.db_escape($supp_custom_four).")";

	db_query($sql,"The supplier additonal information could not be added");
}

function update_supplier_additional_info($supp_supplier_id, $supp_city, $supp_department, $supp_country, 
	$supp_postcode, $supp_doc_type, $supp_valid_digit, $supp_start_date, $supp_sector, $supp_class, $supp_custom_one, 
	$supp_custom_two, $supp_custom_three, $supp_custom_four)
{
	$date = date2sql($supp_start_date);
	$sql = "UPDATE ".TB_PREF."addfields_supp SET 
		supp_supplier_id=" . db_escape($supp_supplier_id) . ", 
		supp_city=" . db_escape($supp_city) . ",
		supp_department=".db_escape($supp_department) . ", 
		supp_country=".db_escape($supp_country) . ", 
		supp_postcode=".db_escape($supp_postcode) . ", 
		supp_doc_type=".db_escape($supp_doc_type) . ", 
		supp_valid_digit=".db_escape($supp_valid_digit) . ",
		supp_start_date='$date', 
		supp_sector=".db_escape($supp_sector) . ", 
		supp_class=" .db_escape($supp_class) . ", 
		supp_custom_one=" .db_escape($supp_custom_one) . ", 
		supp_custom_two=" .db_escape($supp_custom_two) . ", 
		supp_custom_three = ".db_escape($supp_custom_three) . ", 
		supp_custom_four=".db_escape($supp_custom_four) ."
		WHERE supp_supplier_id = ".db_escape($supp_supplier_id);

	db_query($sql,"The supplier additonal information could not be updated");
}

function delete_supplier_additional_info($supplier_id)
{
	$sql="DELETE FROM ".TB_PREF."addfields_supp WHERE supp_supplier_id=".db_escape($supplier_id);
	db_query($sql,"check failed");
}

// function get_supplier_detailsxxx($supplier_id, $to=null, $all=true)
// {

// 	if ($to == null)
// 		$todate = date("Y-m-d");
// 	else
// 		$todate = date2sql($to);
// 	$past1 = get_company_pref('past_due_days');
// 	$past2 = 2 * $past1;
// 	// removed - supp_trans.alloc from all summations

// 	if ($all)
//     	$value = "(trans.ov_amount + trans.ov_gst + trans.ov_discount)";
//     else	
//     	$value = "IF (trans.type=".ST_SUPPINVOICE." OR trans.type=".ST_BANKDEPOSIT."
//   	OR (trans.type=".ST_JOURNAL." AND (trans.ov_amount + trans.ov_gst + trans.ov_discount)>0), 1, -1)*
//     		ABS(trans.ov_amount + trans.ov_gst + trans.ov_discount) - trans.alloc)";

// 	$due = "IF (trans.type=".ST_SUPPINVOICE." OR trans.type=".ST_SUPPCREDIT.",trans.due_date,trans.tran_date)";
//     $sql = "SELECT supp.supp_name, supp.curr_code, ".TB_PREF."payment_terms.terms,

// 		Sum(IFNULL($value,0)) AS Balance,

// 		Sum(IF ((TO_DAYS('$todate') - TO_DAYS($due)) > 0,$value,0)) AS Due,
// 		Sum(IF ((TO_DAYS('$todate') - TO_DAYS($due)) > $past1,$value,0)) AS Overdue1,
// 		Sum(IF ((TO_DAYS('$todate') - TO_DAYS($due)) > $past2,$value,0)) AS Overdue2,
// 		supp.credit_limit - Sum(IFNULL(IF(trans.type=".ST_SUPPCREDIT.", -1, 1) 
// 			* (ov_amount + ov_gst + ov_discount),0)) as cur_credit,
// 		supp.tax_group_id

// 		FROM ".TB_PREF."suppliers supp
// 			 LEFT JOIN ".TB_PREF."supp_trans trans ON supp.supplier_id = trans.supplier_id AND trans.tran_date <= '$todate',
// 			 ".TB_PREF."payment_terms

// 		WHERE
// 			 supp.payment_terms = ".TB_PREF."payment_terms.terms_indicator
// 			 AND supp.supplier_id = $supplier_id ";
// 	if (!$all)
// 		$sql .= "AND ABS(trans.ov_amount + trans.ov_gst + trans.ov_discount) - trans.alloc > ".FLOAT_COMP_DELTA." ";  
// 	$sql .= "GROUP BY
// 			  supp.supp_name,
// 			  ".TB_PREF."payment_terms.terms,
// 			  ".TB_PREF."payment_terms.days_before_due,
// 			  ".TB_PREF."payment_terms.day_in_following_month";
//     $result = db_query($sql,"The customer details could not be retrieved");
//     $supp = db_fetch($result);

//     return $supp;
// }

function get_supplier_additional_info($supplier_id)
{
	$sql = "SELECT * FROM ".TB_PREF."addfields_supp WHERE supp_supplier_id=".db_escape($supplier_id);

	$result = db_query($sql, "could not get supplier additonal information");

	return db_fetch($result);
}


