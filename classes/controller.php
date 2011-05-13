<?php
class controller {

function menu_switcher() {
global $page;	
	switch ($page) {
			case 'rezervimet':
			return $this->rezervimet_switcher();
			break;
			
			case 'agjentet':
			return 'agjentet';
			break;
			
			case 'destinacionet':
			return 'Destinacionet';
			break;			
			
			default:
			return 'rezervimet';
			break;
		}
		
	}
	
function rezervimet_switcher() {
global $subpage;
	switch ($subpage) {
		case 'rezervo':
		return '<div id="Formulari">'.Modelet::rezervo().'</div>';
		break;
		
		case 'lista':
		return 'lista';
		break;
		
		default:
			return 'rezervo';;
		break;
	}
	
}
	
}//endof controller

class Modelet {

function rezervo() {
return '
<form action="" method="post">
<table width="605" cellspacing="5" cellpadding="0" border="0">
<tr>
	<td width="100">
		Prej:
	</td>
	<td>
		<select class="selectDest">
			<option>Tetovo</option>
			<option>Gostivar</option>
		</select>
	</td>
	
	<td width="100">
		Prej:
	</td>
	<td>
		<select class="selectDest">
			<option>Stuttgart</option>
			<option>Berlin</option>
		</select>
	</td>
</tr>

<tr>
	<td width="80">
		Deri:
	</td>
	<td>
		<select class="selectDest">
			<option>Stuttgart</option>
			<option>Berlin</option>
		</select>
	</td>

	<td width="40">
		Deri:
	</td>
	<td>
		<select class="selectDest">
			<option>Tetovo</option>
			<option>Gostivar</option>
		</select>
	</td>
</tr>

<tr>

	<td>
			<form name="Data1Drejtim">
			<label for="data1drejtim">Data e nisjes:</label>
	</td>
		<td>
			
			<input type="text" id="data1drejtim" name="data1drejtim">
				<script language="JavaScript">

				
	// whole calendar template can be redefined per individual calendar
	var A_CALTPL = {
		\'months\' : [\'Janar\', \'Shkurt\', \'Mars\', \'Prill\', \'Maj\', \'Qershor\', \'Korrik\', \'Gusht\', \'Shtator\', \'Tetor\', \'Nentor\', \'Dhjetor\'],
		\'weekdays\' : [\'Di\', \'He\', \'Ma\', \'Me\', \'Ej\', \'Pr\', \'Sh\'],
		\'yearscroll\': true,
		\'weekstart\': 0,
		\'centyear\'  : 70,
		\'imgpath\' : \'images/\'
	}
	
	new tcal ({
		// if referenced by ID then form name is not required
		\'controlname\': \'data1drejtim\'
	}, A_CALTPL);
	</script>
				
			</form>
	</td>
		
	<!--      ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~            -->
	
	<td>
		<form name="DataKthyese">
		<label for="dataKthyese">Data kthyese:</label>
	</td>		
	<td>
					
			<input type="text" id="dataKthyese" name="dataKthyese">
				<script language="JavaScript">

				
	// whole calendar template can be redefined per individual calendar
	var A_CALTPL = {
		\'months\' : [\'Janar\', \'Shkurt\', \'Mars\', \'Prill\', \'Maj\', \'Qershor\', \'Korrik\', \'Gusht\', \'Shtator\', \'Tetor\', \'Nentor\', \'Dhjetor\'],
		\'weekdays\' : [\'Di\', \'He\', \'Ma\', \'Me\', \'Ej\', \'Pr\', \'Sh\'],
		\'yearscroll\': true,
		\'weekstart\': 0,
		\'centyear\'  : 70,
		\'imgpath\' : \'images/\'
	}
	
	new tcal ({
		// if referenced by ID then form name is not required
		\'controlname\': \'dataKthyese\'
	}, A_CALTPL);
	</script>
			</form>
		</td>
		
	</tr>
</table>


<table width="585" cellspacing="0" cellpadding="3" border="0">
<tr>
	<td width="100">
		<input type="radio" id="1drejtim" name="drejtimi" checked value="1drejtim">
		<label for="1drejtim">Nje drejtim</label>
	</td>

	<td >
		<input type="radio" id="kthyese" name="drejtimi" value="kthyese">
		<label for="1drejtim">Kthyese</label>
	</td>
	
	<td>
	<input style="float:right;" type="submit" value="rezervo" />
	</td>
</tr>
</table>



</form><!-- end of the reservation form-->
';	
	
}	
	
	
	
}//endof Modelet

?>