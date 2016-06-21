<?php

class elements
{

	public static function userButton($userName)
	{

		$userResult = database::fetchRows('users', 'fav_civ', 'name', $userName);
		$userRow = $userResult->fetch_assoc();
		$civRow = database::idToValue('civilization', 'name', $userRow['fav_civ']);
		$url = router::createUserUrl($userName);

		if(file_exists('images/' . $civRow['0'] . '.jpg'))
		{
			$pictureUrl = '/images/' . $civRow['0'] . '.jpg';
		}
		elseif(file_exists('images/' . $civRow['0'] . '.png'))
		{
			$pictureUrl = '/images/' . $civRow['0'] . '.png';
		}
		else
		{
			$pictureUrl = '/images/civ.jpg';
		}

		$button = '<div id="rbutton">
				<div class="circle">
					<a href="' . $url . '">
						<img style="border-radius: 50%;" src="' . $pictureUrl .'" />
					</a>
				</div>
			</div>';

		return $button;
	}

}

?>