<?php

if(isset($_POST['submitCiv']))
{
	if(!isset($_POST['civCulture']) || !isset($_POST['uniqueType1']) || !isset($_POST['uniqueType2']))
	{
		$errorCode = 0;
	}
	elseif(trim($_POST['civName']) == '' || trim($_POST['civLeader']) == '' || trim($_POST['civCulture']) == '' || trim($_POST['civAdvantageName']) == '' || trim($_POST['civAdvantageDesc']) == '' || trim($_POST['uniqueName1']) == '' || trim($_POST['uniqueType1']) == '' || trim($_POST['uniqueDesc1']) == '' || trim($_POST['uniqueName2']) == '' || trim($_POST['uniqueType2']) == '' || trim($_POST['uniqueDesc2']) == '')
	{
		$errorCode = 0;
	}
	elseif(strlen($_POST['civName']) > 32 || strlen($_POST['civLeader']) > 64 || strlen($_POST['civCulture']) > 32 || strlen($_POST['civAdvantageName']) > 255 || strlen($_POST['civAdvantageDesc']) > 1024 || strlen($_POST['uniqueName1']) > 255 || strlen($_POST['uniqueType1']) > 2 || strlen($_POST['uniqueDesc1']) > 1024 || strlen($_POST['uniqueName2']) > 255 || strlen($_POST['uniqueType2']) > 2 || strlen($_POST['uniqueDesc2']) > 1024)
	{
		$errorCode = 1;
	}
	else
	{
		$result = database::fetchRows('civilization', 'id', 'name', $_POST['civName']);
		if($result->num_rows > 0)
		{
			$errorCode = 2;
		}
		else
		{
			$idRow = $result->fetch_row();

			$values = array('name' => trim($_POST['civName']), 'leader' => trim($_POST['civLeader']), 'culture' => trim($_POST['civCulture']));
			database::addRow('civilization', $values);
			$values = array('civ_id' => $idRow[0], 'name' => trim($_POST['civAdvantageName']), 'description' => trim($_POST['civAdvantageDesc']), 'type' => 'UA');
			database::addRow('uniques', $values);
			$values = array('civ_id' => $idRow[0], 'name' => trim($_POST['uniqueName1']), 'description' => trim($_POST['uniqueDesc1']), 'type' => trim($_POST['uniqueType1']));
			database::addRow('uniques', $values);
			$values = array('civ_id' => $idRow[0], 'name' => trim($_POST['uniqueName2']), 'description' => trim($_POST['uniqueDesc2']), 'type' => trim($_POST['uniqueType2']));
			database::addRow('uniques', $values);

			$errorCode = 3;
		}
	}
} 

if(isset($_SESSION['user']))
{
	$result = database::fetchRows('users', 'admin', 'name', $_SESSION['user']);
	$userRow = $result->fetch_assoc();
	

	if($userRow['admin'] > 0)
	{
		echo 	'<div class="content">
				<p class="title">Add another civ</p>
				<p class="text">';

		if(isset($errorCode))
		{
			$errors = array('Not every field has been filled!', 'Too long values have been submitted!','This civ already exists!' , 'Civ succesfully added!');
			echo $errors[$errorCode];
		}

		echo			'<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
						<input type="text" name="civName" placeholder="Civ name">
						<input type="text" name="civLeader" placeholder="Civ leader">
						<select name="civCulture">
							<option selected disabled>Select culture</option>
							<option value="African">African</option>
							<option value="Amercian">Amercian</option>
							<option value="Asian">Asian</option>
							<option value="European">European</option>
							<option value="Mediterranean">Mediterranean</option>
							<option value="Polynesian">Polynesian</option>
						</select><br/>
						<input type="text" name="civAdvantageName" placeholder="Civ advantage name"><br/>
						<textarea name="civAdvantageDesc" placeholder="Civ advantage description"></textarea><br/>
						<input type="text" name="uniqueName1" placeholder="Civ unique name">
						<select name="uniqueType1">
							<option selected disabled>Select civ unique type</option>
							<option value="UB">UB</option>
							<option value="UI">UI</option>
							<option value="UU">UU</option>

						</select><br/>
						<textarea name="uniqueDesc1" placeholder="Civ unique description"></textarea><br/>
						<input type="text" name="uniqueName2" placeholder="Civ unique name">
						<select name="uniqueType2">
							<option selected disabled>Select civ unique type</option>
							<option value="UB">UB</option>
							<option value="UI">UI</option>
							<option value="UU">UU</option>

						</select><br/>
						<textarea name="uniqueDesc2" placeholder="Civ unique description"></textarea><br/>
						<input type="submit" value="Create civ" name="submitCiv">
				</p>
			</div>';

		$result = database::fetchRows('users', 'name, tag', 'admin', 1);

		echo 	'<div class="content">
				<p class="title">Admins</p>
				<p class="text">';
		while($adminRow = $result->fetch_assoc())
		{
			echo $adminRow['name'], ' <em>', $adminRow['tag'], '</em><br/>';
		}
		echo '		</p>
			</div>';
	} 
	else
	{
		$result = database::fetchRows('users', 'name, tag', 'admin', 1);

		echo 	'<div class="content">
				<p class="title">Our beloved admins</p>
				<p class="text">';
		while($adminRow = $result->fetch_assoc())
		{
			echo $adminRow['name'], ' <em>', $adminRow['tag'], '</em><br/>';
		}
		echo '		</p>
			</div>';
	}
}
else
{
	echo 	'<div class="content">
			<p class="title">Login required!</p>
			<p class="text">You need to be logged in to view this page.</p>
		</div>';
}

?>