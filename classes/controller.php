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
		return Modelet::rezervo();
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
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td width="40">
		Prej:
	</td>
	<td>
		<select class="selectDest">
			<option>Tetovo</option>
			<option>Gostivar</option>
		</select>
	</td>
</tr>

<tr>
	<td width="40">
		Deri:
	</td>
	<td>
		<select class="selectDest">
			<option>Stuttgart</option>
			<option>Berlin</option>
		</select>
	</td>
</tr>

<tr>
	<td width="40">
		Prej:
	</td>
	<td>
		<select class="selectDest">
			<option>Tetovo</option>
			<option>Gostivar</option>
		</select>
	</td>
</tr>

<tr>
	<td width="40">
		Deri:
	</td>
	<td>
		<select class="selectDest">
			<option>Stuttgart</option>
			<option>Berlin</option>
		</select>
	</td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td width="100">
		<input type="radio" id="1drejtim">
		<label for="1drejtim">Nje drejtim</label>
	</td>

	<td >
		<input type="radio" id="kthyese">
		<label for="1drejtim">Kthyese</label>
	</td>
</tr>

</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td>
			<form name="Data1Drejtim">
			<label for="data1drejtim">Data e nisjes:</label>
			<input type="text" id="data1drejtim" name="data1drejtim">
				<script language="JavaScript">
				new tcal ({
				// form name
				\'formname\': \'Data1Drejtim\',
				// input name
				\'controlname\': \'data1drejtim\'
					});
				</script>
			</form>
		</td>
	</tr>
	
	<tr>
		<td>
			<form name="DataKthyese">
			<label for="dataKthyese">Data kthyese:</label>		
			<input type="text" id="dataPrej" name="dataPrej">
				<script language="JavaScript">
				new tcal ({
				// form name
				\'formname\': \'DataKthyese\',
				// input name
				\'controlname\': \'dataPrej\'
					});
				</script>
			</form>
		</td>
	</tr>
</table>
<input style="margin-left:200px;margin-top:10px;" type="submit" value="rezervo" />
</form><!-- end of the reservation form-->
';	
	
}	
	
	
	
}//endof Modelet

?>