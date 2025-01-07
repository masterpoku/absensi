<?php

$host = 'emqx.mandatera.id';  // Ganti dengan alamat broker EMQX Anda
$port = 1883;                 // Port default untuk MQTT
$client_id = 'mqttx_75cb9901';  // ID unik untuk client MQTT
$username = 'hanif';           // Ganti dengan username broker MQTT (jika ada)
$password = 'qwerty123';       // Ganti dengan password broker MQTT (jika ada)
$topic = 'data/topic';         // Topik yang ingin dipublikasikan atau disubscribe
$message = 'Hello MQTT without library';  // Pesan yang ingin dipublikasikan

// Membuka koneksi socket ke broker MQTT menggunakan tcp://
$socket = fsockopen("tcp://$host", $port, $errno, $errstr, 10);
if (!$socket) {
    die("Error connecting to broker: $errstr ($errno)\n");
}

// Fungsi untuk membuat paket CONNECT MQTT
function mqttConnect($client_id, $username, $password) {
    $protocolName = 'MQTT';
    $protocolLevel = 4; // Versi 3.1.1
    $connectFlags = 0x02; // Menggunakan password (bisa disesuaikan)
    $keepAlive = 60; // Interval keep-alive 60 detik

    $packet = chr(0x10); // Tipe paket CONNECT
    $packet .= chr(0x00) . chr(0x04) . 'MQTT'; // Nama protokol
    $packet .= chr($protocolLevel); // Level protokol
    $packet .= chr($connectFlags); // Flag koneksi
    $packet .= chr(($keepAlive >> 8) & 0xFF) . chr($keepAlive & 0xFF); // Keep Alive (2 byte)
    $packet .= chr((strlen($client_id) >> 8) & 0xFF) . chr(strlen($client_id) & 0xFF); // Panjang Client ID
    $packet .= $client_id; // Client ID

    if (!empty($username)) {
        $packet .= chr((strlen($username) >> 8) & 0xFF) . chr(strlen($username) & 0xFF); // Panjang Username
        $packet .= $username;
    }

    if (!empty($password)) {
        $packet .= chr((strlen($password) >> 8) & 0xFF) . chr(strlen($password) & 0xFF); // Panjang Password
        $packet .= $password;
    }

    return $packet;
}

// Kirim paket CONNECT ke broker
$connectPacket = mqttConnect($client_id, $username, $password);
fwrite($socket, $connectPacket);

// Tunggu hingga broker mengirimkan CONNACK
$response = fread($socket, 4);
if (strlen($response) < 4 || ord($response[3]) !== 0x00) {
    die("Failed to connect to broker. Response: " . bin2hex($response) . "\n");
}

// Kirim pesan dengan paket PUBLISH (menggunakan fitur retain)
function mqttPublish($topic, $message, $retain = false) {
    if (!is_bool($retain)) {
        $retain = (bool)$retain; // Ensure retain is a boolean
    }

    $topicLength = strlen($topic);
    $messageLength = strlen($message);
    $packet = chr(0x30); // Packet type = PUBLISH (0x30)

    // Calculate remaining length
    $remainingLength = 2 + $topicLength + $messageLength;
    $packet .= chr($remainingLength); // Remaining Length

    // Topic
    $packet .= chr(($topicLength >> 8) & 0xFF) . chr($topicLength & 0xFF); // Topic Length
    $packet .= $topic; // Topic

    // Payload (Message)
    $packet .= $message; // Message

    // QoS = 0, retain = true
    if ($retain) {
        $packet |= 0x01; // Set retain flag (bitwise OR)
    }

    return $packet;
}

// Kirim pesan PUBLISH dengan retain flag
$publishPacket = mqttPublish($topic, $message, true);
fwrite($socket, $publishPacket);

// Membaca pesan balasan (untuk mengecek apakah publikasi berhasil)
$response = fread($socket, 4);
if (strlen($response) < 4 || ord($response[0]) !== 0x30) {
    die("Failed to publish message. Response: " . bin2hex($response) . "\n");
}

// Menutup koneksi
fclose($socket);
echo "Pesan diterbitkan ke topik '$topic' dengan retain flag.\n";

?>