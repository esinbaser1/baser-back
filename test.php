<?php

$secretKey = bin2hex(random_bytes(32));
echo $secretKey;

// $data = "Hello, World!";

// $encoded = base64_encode($data);
// // echo $encoded;  // SGVsbG8sIFdvcmxkIQ==

// $decoded = base64_decode($encoded);
// echo $decoded;  // Hello, World!
