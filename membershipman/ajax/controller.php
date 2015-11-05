<?php
  /**
   * Controller
   *
   */
  define("_VALID_PHP", true);
  require_once("../init.php");

  if (!$user->logged_in)
      exit;
?>
<?php
  /* Proccess Cart */
  if (isset($_POST['addtocart'])):
      $row = Core::getRowById(Membership::mTable, Filter::$id);

      if ($row):
          $gaterows = Registry::get("Membership")->getGateways(true);
		  
          if ($row->trial && $user->trialUsed()) :
              $json['message'] = Filter::msgSingleAlert(Core::$word->UA_TRIAL_USED, false);
              print json_encode($json);
              exit;
          endif;
          if ($row->price == 0) :
              $data = array(
                  'membership_id' => $row->id,
                  'mem_expire' => $user->calculateDays($row->id),
                  'trial_used' => ($row->trial == 1) ? 1 : 0
				  );

              $db->update(Users::uTable, $data, "id=" . $user->uid);
              $json['message'] = Filter::msgSingleOk(Core::$word->UA_MEM_ACTIVE_OK . ' ' . $row->title, false);
              print json_encode($json);

          else :
		      $recurring = ($row->recurring == 1) ? Core::$word->YES : Core::$word->NO;
			  $db->delete(Content::crTable, "uid = " . $user->uid);
			  $tax = Core::calculateTax();
			  $data = array(
				  'uid' => $user->uid,
				  'mid' => $row->id,
				  'cid' => 0,
				  'coupon' => 0.00,
				  'originalprice' => $row->price,
				  'tax' => $tax,
				  'totaltax' => $row->price * $tax,
				  'total' => $row->price,
				  'totalprice' => $tax * $row->price + $row->price,
				  'created' => "NOW()",
				  );
			  $db->insert(Content::crTable, $data);
			  $cart = Core::getCart();
		      $html = '
			  <table class="wojo basic table">
				<thead>
				  <tr>
					<th colspan="2">' . Core::$word->UA_P_SUMMARY . '</th>
				  </tr>
				</thead>
				<tr>
				  <th>' . Core::$word->MM_TTITLE . '</th>
				  <td>' . $row->title . '</td>
				</tr>
				<tr>
				  <th>' . Core::$word->PRICE . '</th>
				  <td>' . $core->formatMoney($cart->total) . '</td>
				</tr>
				<tr>
				  <th>' . Core::$word->N_DISC . '</th>
				  <td class="disc">0.00</td>
				</tr>';
				if ($core->enable_tax) :
				$html .='
				<tr>
				  <th>' . Core::$word->VAT . '</th>
				  <td class="totaltax">' . $core->formatMoney($cart->total * $cart->tax) . '</td>
				</tr>';
				endif;
				$html .='
				<tr class="positive">
				  <th>' . Core::$word->TOAMT . '</th>
				  <td class="totalamt">' . $core->formatMoney($cart->tax * $cart->total + $cart->total) . '</td>
				</tr>
				<tr>
				  <th>' . Core::$word->MM_PERIOD . '</th>
				  <td>' . $row->days . ' ' .$member->getPeriod($row->period) . '</td>
				</tr>
				<tr>
				  <th>' . Core::$word->RECURRING . '</th>
				  <td>' . $recurring . '</td>
				</tr>
				<tr>
				  <th>' . Core::$word->UA_VALID_UNTIL . '</th>
				  <td>' .  $member->calculateDays($row->period, $row->days) . '</td>
				</tr>
				<tr>
				  <th>' . Core::$word->MM_DESC . '</th>
				  <td>' . $row->description . '</td>
				</tr>
				<tr>
				  <th>' . Core::$word->DC_CODE . '</th>
				  <td><div class="wojo small icon input">
					  <input type="text" placeholder="' . Core::$word->DC_CODE_I . '" name="coupon">
					  <i data-id="' . $row->id . '" id="cinput" class="tag circular black inverted icon link"></i> </div>
				  </td>
				</tr>
				<tr id="gatedata">
				  <th>' . Core::$word->UA_P_PAYWITH . '</th>
				  <td>
					<div class="inline-group">';
					foreach ($gaterows as $grows) :
					if ($row->recurring and !$grows->is_recurring):
					   break;
					   else :
					$html .= '
					  <label class="radio">
						<input name="gateway" data-gateway= "' . $grows->id . '" type="radio" value="' . $row->id . '">
						<i></i>' . $grows->displayname . '</label>';
						endif;
					endforeach;
					$html .='
					</div>
				  </td>
				</tr>
				<tr>
				  <td colspan="2" id="gdata"></td>
				</tr>
			  </table>';
			  $json['message'] = $html;
			  print json_encode($json);
          endif;
		  
      else :
		  $json['message'] = Filter::msgSingleError(Core::$word->SYSERROR, false);
		  print json_encode($json);
		  exit;
      endif;
  endif;

  /* Proccess Coupon */
  if (isset($_GET['doCoupon'])):
      if ($row = $db->first("SELECT * FROM " . Content::dTable . " WHERE FIND_IN_SET(" . Filter::$id . ", mid) AND code = '" . sanitize($_GET['code']) . "' AND active = 1")):
		  $row2 = Core::getRowById(Membership::mTable, Filter::$id);
		  
		  $db->delete(Content::crTable, "uid = " . $user->uid);
		  $tax = Core::calculateTax();
		  
          if ($row->type == "p"):
              $disc = number_format($row2->price / 100 * $row->discount, 2);
              $gtotal = number_format($row2->price - $disc, 2);
          else:
              $disc = number_format($row->discount, 2);
              $gtotal = number_format($row2->price - $disc, 2);
          endif;

		  $data = array(
		      'uid' => $user->uid,
			  'mid' => $row2->id,
			  'cid' => $row->id,
			  'totaltax' => $gtotal * $tax,
			  'coupon' => $disc,
			  'total' => $gtotal,
			  'originalprice' => $row2->price,
			  'totalprice' => $tax * $gtotal + $gtotal,
			  'created' => "NOW()"
			  );
		  $db->insert(Content::crTable, $data);

		  $json['type'] = "success";
		  $json['disc'] = "- " . $core->formatMoney($disc);
		  $json['tax'] = $core->formatMoney($data['totaltax']);
		  $json['gtotal'] = $core->formatMoney($data['totalprice']);
		  print json_encode($json);
      else:
		  $json['type'] = "error";
		  print json_encode($json);
	  endif;
  endif;
  
  /* Load Gateway */
  if (isset($_GET['loadGateway'])):
      $row = Core::getRowById(Membership::mTable, Filter::$id);
      if ($row):
          $grows = Core::getRowById(Membership::gTable, intval($_GET['mid']));
          $form_url = BASEPATH . "gateways/" . $grows->dir . "/form.tpl.php";
		  
		  $html = '';
          ob_start();
          include ($form_url);
          $html .= ob_get_contents();
          ob_end_clean();
		  
          $json['message'] = $html;
          print json_encode($json);
      else:
          $json['message'] = Filter::msgSingleError(Core::$word->SYSERROR, false);
          print json_encode($json);
          exit;
      endif;
  endif;
  
  /* Proccess User */
  if (isset($_POST['processUser'])):
      if (intval($_POST['processUser']) == 0 || empty($_POST['processUser'])):
          exit;
      endif;
      $user->updateProfile();
  endif;
  
  /* Get Invoice */
  if (isset($_GET['doInvoice'])):
      $row = $member->getUserInvoice(Filter::$id);
      if ($row):
          $usr = Registry::get("Core")->getRowById(Users::uTable, Registry::get("Users")->uid);

          $title = cleanOut(preg_replace("/[^a-zA-Z0-9\s]/", "", $row->title));
          ob_start();
          require_once (BASEPATH . 'assets/print_pdf.tpl.php');
          $pdf_html = ob_get_contents();
          ob_end_clean();

          require_once (BASEPATH . 'lib/mPdf/mpdf.php');
          $mpdf = new mPDF('utf-8', "A4");
          $mpdf->SetTitle($title);
          $mpdf->SetAutoFont();
          $mpdf->WriteHTML($pdf_html);
          $mpdf->Output($title . ".pdf", "D");
          exit;
      else:
          exit;
      endif;
  endif;
?>