<?php
require_once 'config/database.php';

$pdo->exec("TRUNCATE platform_benefits");

$benefits = [
    ['title' => 'ইন্ডাস্ট্রি এক্সপার্ট মেন্টরদের গাইডলাইন', 'icon' => 'fa-users'],
    ['title' => 'রিয়েল-লাইফ প্রজেক্ট ও প্র্যাকটিক্যাল লার্নিং', 'icon' => 'fa-code'],
    ['title' => 'ইন্ডাস্ট্রি রিলেভেন্ট স্কিলস ডেভেলপমেন্ট', 'icon' => 'fa-graduation-cap'],
    ['title' => 'বেস্ট কোর্স আউটলাইন', 'icon' => 'fa-list-ul'],
    ['title' => 'ক্যারিয়ার পাথ বেইজড সাপোর্ট সেশন', 'icon' => 'fa-headset'],
    ['title' => 'জব প্লেসমেন্ট সাপোর্ট', 'icon' => 'fa-briefcase'],
    ['title' => 'টেকনিক্যাল সাপোর্ট', 'icon' => 'fa-tools'],
    ['title' => 'ইন্টার্নশিপ ও চাকরির সুযোগ', 'icon' => 'fa-handshake-o'],
    ['title' => 'অ্যাফোর্ডেবল প্রাইসে লার্নিং', 'icon' => 'fa-tag'],
    ['title' => 'লাইফটাইম লার্নিং অ্যাক্সেস', 'icon' => 'fa-infinity']
];

foreach ($benefits as $b) {
    $stmt = $pdo->prepare("INSERT INTO platform_benefits (title, icon) VALUES (?, ?)");
    $stmt->execute([$b['title'], $b['icon']]);
}

echo "Benefits re-seeded with correct encoding!";
?>
