<?php
require_once 'config/database.php';

$courseids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$instructor_ids = [1, 2, 3, 4, 6, 7, 9];

echo "Cleaning old data...\n";
$pdo->exec("TRUNCATE course_outcomes");
$pdo->exec("TRUNCATE course_features");
$pdo->exec("TRUNCATE course_faqs");
$pdo->exec("TRUNCATE course_projects");
$pdo->exec("TRUNCATE course_testimonials");
$pdo->exec("TRUNCATE course_instructors");

foreach($courseids as $cid) {
    echo "Seeding Course $cid...\n";

    // Outcomes
    $outcomes = [
        "মাস্টার PHP এবং আধুনিক ফ্রেমওয়ার্ক Laravel 12",
        "প্রফেশনাল লেভেলে রিয়েল-লাইফ প্রজেক্ট ডেভেলপমেন্ট",
        "ব্যাকএন্ড এপিআই এবং সার্ভিস ওরিয়েন্টেড ডিজাইন",
        "ডিপলি শিখবেন ডেটাবেস ডিজাইন এবং কোয়েরি অপ্টিমাইজেশন",
        "জব এবং ফ্রিল্যান্সিং ক্যারিয়ারের জন্য কমপ্লিট গাইডেন্স"
    ];
    foreach($outcomes as $o) {
        $pdo->prepare("INSERT INTO course_outcomes (course_id, outcome) VALUES (?, ?)")->execute([$cid, $o]);
    }

    // Features
    $features = [
        "১০০+ প্রি-রেকর্ডড ভিডিও লসন",
        "১০টি পজিটিভ রিয়েল লাইফ প্রজেক্ট",
        "৪০+ পজিটিভ লাইভ ক্লাস সেশন",
        "প্রতিদিন ৬ বেলা এক্সপার্ট সাপোর্ট সেশন",
        "ইন্টারভিউ প্রিপারেশন এবং হ্যান্ডবুক",
        "জব প্লেসমেন্ট এবং ক্যারিয়ার গাইডেন্স"
    ];
    foreach($features as $f) {
        $pdo->prepare("INSERT INTO course_features (course_id, feature) VALUES (?, ?)")->execute([$cid, $f]);
    }

    // FAQs
    $faqs = [
        ["এই কোর্সটি কাদের জন্য?", "যারা একদম স্ক্র্যাচ থেকে ওয়েব ডেভেলপমেন্ট শিখে প্রফেশনাল ক্যারিয়ার গড়তে চান।"],
        ["ক্লাস কখন হয়?", "সপ্তাহে ৩ দিন রাত ৯টা থেকে ১১টা পর্যন্ত ইন্টারঅ্যাক্টিভ লাইভ সেশন।"],
        ["সার্টিফিকেট কি পাওয়া যাবে?", "হ্যাঁ, সফলভাবে কোর্স শেষ করলে ভেরিফাইড সার্টিফিকেট প্রদান করা হবে।"],
        ["ল্যাপটপ কি বাধ্যতামূলক?", "যেকোনো সাধারণ মানের ল্যাপটপ বা পিসি দিয়ে আপনি প্র্যাকটিস করতে পারবেন।"]
    ];
    foreach($faqs as $fq) {
        $pdo->prepare("INSERT INTO course_faqs (course_id, question, answer) VALUES (?, ?, ?)")->execute([$cid, $fq[0], $fq[1]]);
    }

    // Projects (Placeholder path)
    $projects = [
        ["ই-কমার্স প্ল্যাটফর্ম", "uploads/courses/course_1.jpg"],
        ["ম্যানেজমেন্ট সিস্টেম", "uploads/courses/course_2.jpg"],
        ["সোশ্যাল মিডিয়া অ্যাপ", "uploads/courses/course_3.jpg"]
    ];
    foreach($projects as $p) {
        $pdo->prepare("INSERT INTO course_projects (course_id, title, image) VALUES (?, ?, ?)")->execute([$cid, $p[0], $p[1]]);
    }

    // Testimonials
    $testimonials = [
        ["জাহিদ হাসান", "সফটওয়্যার ইঞ্জিনিয়ার", "অসাধারণ একটি লার্নিং জার্নি ছিল। ট্রেইনারদের সাপোর্ট ছিল চমৎকার!", 5],
        ["আরিফুল ইসলাম", "স্টুডেন্ট", "কোর্স কারিকুলাম ছিল আপ-টু-ডেট এবং প্রজেক্টগুলো অনেক হেল্পফুল ছিল।", 5]
    ];
    foreach($testimonials as $t) {
        $pdo->prepare("INSERT INTO course_testimonials (course_id, student_name, student_role, comment, rating) VALUES (?, ?, ?, ?, ?)")->execute([$cid, $t[0], $t[1], $t[2], $t[3]]);
    }

    // Instructors
    shuffle($instructor_ids);
    $selected = array_slice($instructor_ids, 0, 2);
    foreach($selected as $u) {
        $pdo->prepare("INSERT INTO course_instructors (course_id, user_id) VALUES (?, ?)")->execute([$cid, $u]);
    }
}

echo "Done seeding all course details!\n";
?>
