<?php
require_once('../lib/text-functions.php');
require_once('../lib/page-header.php');
require_once('../lib/header.php');
require_once('catalog.php');
?>
<div data-role="content">
<?php


if (isset($_POST['trecord_id']) || isset($_POST['erecord_id'])){
    // TODO: Get record data

    if (isset($_POST['erecord_id'])) {
	$record_id = $_POST['erecord_id'];
    } else {
	$record_id = $_POST['trecord_id'];
    }

    $record_xml = search_detail($record_id);

    if (!$record_xml) {
        print "Bad or no XML";
        return;
    }


    $title = urlencode(trim(utf8_decode($record_xml->item->title)));
    $author = urlencode(trim(utf8_decode($record_xml->item->author)));
    $pubDate = urlencode(trim($record_xml->item->pubDate));
    $format = urlencode(trim($record_xml->item->format));
    $isbn = urlencode(trim($record_xml->item->isbn));


    if (strlen($title) > 0) {
        $record_data = "Title: $title\n";
        $text_data = truncate($title, 28) . "\n";
    }


    if (strlen($author) > 0) {
        $record_data .= "Author: $author\n";
        $text_data .= truncate($author, 25) . "\n";
    }

    if (strlen($pubDate) > 0) {
        $record_data .= "Publication Date: $pubDate\n";
    }

    if (strlen($format) > 0) {
        $record_data .= "Format: $format\n";
    }

    if (strlen($isbn) > 0) {
        $record_data .= "ISBN: $isbn\n";
    }

    $record_data .= "\nLocations:";
    $loc_count = 0;
    foreach($record_xml->item->holdings->library as $library) {
        $libraryname = urlencode(trim($library->attributes()->name));

        if (strlen($libraryname) > 0) {
            $record_data .= "\n\nLibrary: $libraryname\n";
            if ($loc_count == 0) {
                $text_data .= "$libraryname\n";
            }
        }

        foreach($library->holdingsItem as $holdingsItem) {
            $loc_count++;
            $callNumber = urlencode(trim($holdingsItem->callNumber));
            $location = urlencode(trim($holdingsItem->location));
            $status = urlencode(trim($holdingsItem->status));



            if (strlen($callNumber) > 0) {
                $record_data .= "\nCall Number: $callNumber\n";
                if ($loc_count == 1) {
                    $text_data .= "$callNumber\n";
                }
            }

            if (strlen($location) > 0) {
                $record_data .= "Location: $location";
                if ($loc_count == 1) {
                    $text_data .= "$location";
                }
                if (isset($holdingsItem->floorLocation)) {
                    $record_data .= ', ' . urlencode(trim($holdingsItem->floorLocation)) . "\n";
                    if ($loc_count == 1) {
                        $text_data .= ', ' . urlencode(trim($holdingsItem->floorLocation)) . "\n";
                    } else {
                        $text_data .= "\n";
                    }
                } else {
                    $record_data .= "\n";
                    if ($loc_count == 1) {
                        $text_data .= "\n";
                    }
                }
            }


            if (strlen($status) > 0) {
                $record_data .= "Availability: $status\n";
                if ($loc_count == 1) {
                    $text_data .= "$status\n";
                }
            }

            if ($loc_count == 2) {
                $text_data .= "See catalog for more";
            }
        }
    }

} else {
    print "No record ID";
    return;
}

if (isset($_POST['text_provider'])) {
    $curl_url = 'http://catalog.lib.ncsu.edu/mailrelay/text/';
    $query_string = 'private_key=d65d731a84116bdc6aa31f55a4b3403f50c38b63';
    //$query_string = "q1=&q2=&q3=c&q4=d&message=" . $text_data;
    $query_string .= '&message=' . $text_data;
    $query_string .= '&sms_provider=' . urlencode($_POST['text_provider']);
    if (isset($_POST['phone_number'])) {
        $normal_number = preg_replace("/[^0-9]/","",$_POST['phone_number']); 
        // Currently supporting US phone numbers
        if (strlen($normal_number) != 10) {
            print "invalid phone number";
            return;
        }
        $query_string .= '&sms_to=' . urlencode($normal_number);
    } else {
        print "no phone number";
        return;
    }

} else {
    $curl_url = 'http://catalog.lib.ncsu.edu/mailrelay/email/';
    $query_string = 'private_key=d65d731a84116bdc6aa31f55a4b3403f50c38b63';
    //$query_string = "q1=&q2=&q3=c&q4=d&content=" . $record_data;
    $query_string .= "&message=" . $record_data;
    if (isset($_POST['email_to'])){
        $query_string .= "&email_to=" . urlencode($_POST['email_to']);
    } else {
        print "no email address";
        return;
    }

    //$query_string .= "&email_from=no-reply@ncsu.edu";
    $query_string .= "&subject=NCSU Libraries Catalog Record";
}

// Return errors???
//
//

$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $curl_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$query_string);
curl_setopt($ch, CURLOPT_FAILONERROR, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_USERAGENT, "NCSU Libraries Mobilib2 Test");
$curl_response = curl_exec($ch);

if ($curl_setopt !== false) {
    print "This record has been successfully sent.";
} else {
    print "There has been an error sending this message";
}

curl_close($ch);
?>
</div><!-- /content -->
<?php
require_once('../lib/footer.php');
?>