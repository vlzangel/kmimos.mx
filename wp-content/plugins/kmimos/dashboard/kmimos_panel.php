<?php global $wpdb;

// **************************
// Style and Script
// **************************
include_once('core/register_style.php');
// **************************
// Reservas Controller
// **************************
require_once('core/ControllerPanel.php');
//$reservas = getReservas();

?>

<table 	id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" 
		cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>First name</th>
      <th>Last name</th>
      <th>Position</th>
      <th>Office</th>
      <th>Age</th>
      <th>Start date</th>
      <th>Salary</th>
      <th>Extn.</th>
      <th>E-mail</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Tiger</td>
      <td>Nixon</td>
      <td>System Architect</td>
      <td>Edinburgh</td>
      <td>61</td>
      <td>2011/04/25</td>
      <td>$320,800</td>
      <td>5421</td>
      <td>t.nixon@datatables.net</td>
    </tr>
  </tbody>
</table>
