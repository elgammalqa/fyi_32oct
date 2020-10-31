<?php
  function createTopic($topic,$id) {
	  $url = 'https://iid.googleapis.com/iid/v1/' . $id . '/rel/topics/' . $topic;
	  $headers = array (
	    'Authorization: key=AAAA3iimkek:APA91bHSL6kf4QrAqilpu9osFr-kXrKRsiNN1b6Lsz0uCTe4wq5vwhv5af-i4dXtlq9dlF67w2mUuesYKR3LZIbWQ3yq9nS_cFEMrlSvwLwX0yzmqqaQOkFGmCQmBer5WtuLHjeOqnpn'
	  );
	  $ch = curl_init ();
	  curl_setopt ( $ch, CURLOPT_URL, $url );
	  curl_setopt ( $ch, CURLOPT_POST, true );
	  curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

	  $result = curl_exec ( $ch );
	  echo $result;
	  curl_close ( $ch );
}

  function unsubscribe($topic,$id) {
	  $url = 'https://iid.googleapis.com/iid/v1/' . $id . '/rel/topics/' . $topic;
	  $headers = array (
	    'Authorization: key=AAAA3iimkek:APA91bHSL6kf4QrAqilpu9osFr-kXrKRsiNN1b6Lsz0uCTe4wq5vwhv5af-i4dXtlq9dlF67w2mUuesYKR3LZIbWQ3yq9nS_cFEMrlSvwLwX0yzmqqaQOkFGmCQmBer5WtuLHjeOqnpn'
	  );
	  $ch = curl_init ();
	  curl_setopt ( $ch, CURLOPT_URL, $url );
	  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	  curl_setopt ( $ch, CURLOPT_POST, true );
	  curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

	  $result = curl_exec ( $ch );
	  echo $result;
	  curl_close ( $ch );
}

unsubscribe('ar-Russia-RT__Arabic', 'ceqmwqoNnehMY-_Mfc2oUS:APA91bH6ejqIP3EmCqSJfxFgIKCADS-pHXn-Lzc9tdRV5H28rdHXyNfUAsLrx1f2YguT-X5rwwFb2jkMf2MtTsbukXbLLw4pAZn-hg7AlwjzGTtaawrEXcb9jPKvdqDwqsaLgwo0Yhef');


?>