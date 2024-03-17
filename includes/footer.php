<?php
$footerContents = [
    [
        "title" => "Academics",
        "url" => "#",
        "content" => [
            [
                "title" => "Academic Courses",
                "url" => "https://mitindia.edu/en/courses",
            ],
            [
                "title" => "ACOE",
                "url" => "https://acoe.annauniv.edu/",
            ],
            [
                "title" => "Academic Schedules",
                "url" => "",
            ],
            [
                "title" => "CSRC",
                "url" => "http://ctdt.annauniv.edu/",
            ],
            [
                "title" => "Students Feedback",
                "url" => "http://fbonline.annauniv.edu:8080/fb/fb.jsp",
            ],
        ],
    ],
    [
        "title" => "Anna University",
        "url" => "#",
        "content" => [
            [
                "title" => "Acts & Statues",
                "url" => "https://www.annauniv.edu/pdf/Acts%20&%20Statues-New.pdf",
            ],
            [
                "title" => "Mandatory Disclosure",
                "url" => "https://iqac.annauniv.edu/",
            ],
            [
                "title" => "Genuineness Verification",
                "url" => "https://gverify.annauniv.edu/",
            ],
            [
                "title" => "NIRF",
                "url" => "https://mitindia.edu/en/administration/office-page",
            ],
            [
                "title" => "University Departments",
                "url" => "https://www.annauniv.edu/univdept.php",
            ],
        ],
    ],
    [
        "title" => "Downloads",
        "url" => "#",
        "content" => [
            [
                "title" => "WiFi Registration",
                "url" => "https://docs.google.com/forms/d/e/1FAIpQLSdfAkiupN8aSNQynN383_njOlsF-E_UWQY50S0DHOGLSzcxBw/viewform",
            ],
            [
                "title" => "MS Teams ID Requisition Form",
                "url" => "https://www.annauniv.edu/rcc/pdf/form%20creating%20MS%20teams.pdf",
            ],
            [
                "title" => "Internet Complaint Booking",
                "url" => "http://bit.ly/mitcccbf",
            ],
            [
                "title" => "More",
                "url" => "/downloads",
            ],
        ],
    ],
    [
        "title" => "Facilities",
        "url" => "#",
        "content" => [
            [
                "title" => "Computer Centre",
                "url" => "https://cc.mitindia.edu/",
            ],
            [
                "title" => "Library",
                "url" => "https://library.annauniv.edu/mit_index.php",
            ],
            [
                "title" => "Health Centre",
                "url" => "http://www.health-centre.mitindia.edu/health_centre/",
            ],
            [
                "title" => "Student Grievance Redressal",
                "url" => "https://docs.google.com/forms/d/e/1FAIpQLScrI2aIZGcv7FyhvQL-0bwJCliULY0dShhKLe7VEQXNT00Bpw/viewform",
            ],
        ],
    ],
];
?>

<div class="footer">
    <div class="footer-wrapper">
        <div class="footer-row">
            <?php foreach ($footerContents as $section) : ?>
                <div class="footer-column">
                    <div class="footer-title"><?php echo $section['title']; ?></div>
                    <?php foreach ($section['content'] as $link) : ?>
                        <a class="footer-link" target="_blank" rel="noreferrer" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <div class="footer-center">
                <div>
                    <i class="fa-solid fa-location-dot"> </i>
                    <p><span>Anna University, MIT Campus</span> Chrompet, Chennai 600044</p>
                </div>
                <div>
                    <i class="fa fa-phone"></i>
                    <p>044 2251 6002</p>
                </div>
                <div>
                    <i class="fa fa-envelope"></i>
                    <p>dean@mitindia.edu</p>
                </div>
            </div>
        </div>
    </div>
</div>