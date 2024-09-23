<?php
function vam_installment_calculator($atts) {
    // Extract attributes
    $atts = shortcode_atts(array(
        'brand' => '',
    ), $atts);

    ob_start(); // Start output buffering
    ?>
    <style>
        @import url('https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css');

        body {
            font-family: 'Vazir', sans-serif;
            direction: rtl;
            padding: 20px;
            background-color: #f4f7fa;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            display: flex;
            justify-content: space-between;
        }

        h1 {
            text-align: center;
            color: #844caf;
            margin-bottom: 20px;
            font-size: 24px;
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
            width: 48%;
            /* Adjust width for form groups */
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
            width: 100%;
        }

        input[type="number"] {
            width: 330px;
            padding: 12px;
            margin-top: 5px;
            border: 2px solid transparent;
            border-radius: 10px;
            outline: none;
            background-color: #f8fafc;
            color: #0d0c22;
            transition: 0.5s;
        }

        select {
            width: 360px;
            padding: 12px;
            margin-top: 5px;
            border: 2px solid transparent;
            border-radius: 10px;
            outline: none;
            background-color: #f8fafc;
            color: #0d0c22;
            transition: 0.5s;
        }

        input[type="range"] {
            width: 350px;
            margin-top: 5px;
            border: 2px solid transparent;
            border-radius: 10px;
            outline: none;
            background-color: #f8fafc;
            color: #0d0c22;
            transition: 0.5s;
        }

        input[type="number"]::placeholder {
            color: #94a3b8;
        }

        input[type="number"]:focus,
        select:focus,
        input[type="range"]:focus {
            border-color: rgba(129, 140, 248);
            background-color: #fff;
            box-shadow: 0 0 0 5px rgb(129 140 248 / 30%);
            transition: 0.5s;
        }

        button {
            width: 100%;
            background-color: #6b4caf;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #5345a0;
        }

        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #c7bef5;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            color: #505050;
            line-height: 1.5;
            background-color: #f8fafc;
            width: 48%;
            /* Adjust width for results */
        }

        .result p {
            background-color: rgba(255, 255, 255, 0.662);
            padding: 15px 20px;
            border-radius: 25px;
            box-shadow: 1px 1px 2px #2727272f;
            transition: 0.3s;
        }

        .result p:active {
            box-shadow: none;
            transition: 0.3s;
        }

        .slider {
            margin-top: 10px;
        }

        .slider-value {
            text-align: center;
            font-weight: bold;
            color: #6b4caf;
        }

        .slider-fu {
            -webkit-appearance: none;
            width: 100%;
            height: 10px;
            border-radius: 5px;
            background-color: #4158D0;
            background-image: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider-fu::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #4c00ff;
            cursor: pointer;
        }

        .slider-fu::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #0093E9;
            background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);
            cursor: pointer;
        }
    </style>
    <div class="container">
        <h1>محاسبه اقساط</h1>

        <div class="form-group">
            <label for="requestedAmount">مبلغ درخواستی (۵ میلیون تا ۱۲۰ میلیون):</label>
            <input class="slider-fu" type="range" id="amountSlider" min="5000000" max="120000000" step="5000000"
                value="0" oninput="updateAmount()">
            <div class="slider-value" id="sliderValue">۵,۰۰۰,۰۰۰ تومان</div>
        </div>

        <div class="form-group">
            <label for="customAmount">یا مبلغ دلخواه:</label>
            <input type="number" value="5000000" id="requestedAmount" placeholder="مبلغ دلخواه را وارد کنید" oninput="calculate()">
        </div>

        <div class="form-group">
            <label for="duration">مدت بازپرداخت (ماه):</label>
            <select id="duration" onchange="calculate()">
                <option value="24">24 ماهه</option>
            </select>
        </div>

        <div class="form-group">
            <label for="brand">انتخاب برند:</label>
            <select id="brand" onchange="calculate()">
                <option value="پاکشوما" <?php selected($atts['brand'], 'پاکشوما'); ?>>پاکشوما</option>
                <option value="مادیران" <?php selected($atts['brand'], 'مادیران'); ?>>مادیران</option>
                <option value="بلانتون" <?php selected($atts['brand'], 'بلانتون'); ?>>بلانتون</option>
                <option value="گلدیران" <?php selected($atts['brand'], 'گلدیران'); ?>>گلدیران</option>
                <option value="کلور">کلور</option>
                <option value="دیپوینت">دیپوینت</option>
                <option value="یوروپلاس">یوروپلاس</option>
                <option value="لایف">لایف</option>
                <option value="سام">سام</option>
                <option value="تاکنو">تاکنو</option>
                <option value="جی سان">جی سان</option>
            </select>
        </div>

        <button onclick="calculate()">محاسبه اقساط</button>
        <div class="result" id="result"></div>
    </div>
    <script>
        const rates = {
            "پاکشوما": { firstHalf: 0.05, secondHalf: 0.24, finalRepayment: 0.23 },
            "مادیران": { firstHalf: 0.23, secondHalf: 0.24, finalRepayment: 0.23 },
            "بلانتون": { firstHalf: 0.12, secondHalf: 0.24, finalRepayment: 0.23 },
            "گلدیران": { firstHalf: 0.23, secondHalf: 0.24, finalRepayment: 0.23 },
            "کلور": { firstHalf: 0.11, secondHalf: 0.24, finalRepayment: 0.23 },
            "دیپوینت": { firstHalf: 0.12, secondHalf: 0.24, finalRepayment: 0.23 },
            "یوروپلاس": { firstHalf: 0.14, secondHalf: 0.24, finalRepayment: 0.23 },
            "لایف": { firstHalf: 0.06, secondHalf: 0.24, finalRepayment: 0.23 },
            "سام": { firstHalf: 0.16, secondHalf: 0.24, finalRepayment: 0.23 },
            "تاکنو": { firstHalf: 0.23, secondHalf: 0.24, finalRepayment: 0.23 },
            "جی سان": { firstHalf: 0.16, secondHalf: 0.24, finalRepayment: 0.23 },
        };

        function updateAmount() {
            const sliderValue = document.getElementById("amountSlider").value;
            document.getElementById("sliderValue").innerText = sliderValue.toLocaleString() + " تومان";
            document.getElementById("requestedAmount").value = sliderValue;
            calculate();
        }

        window.onload = function () {
            calculate();
        }

        function calculate() {
            const amount = parseFloat(document.getElementById("requestedAmount").value);
            const brand = document.getElementById("brand").value;
            const n = parseInt(document.getElementById("duration").value);

            if (isNaN(amount) || amount <= 0 || n <= 0) {
                document.getElementById("result").innerText = "";
                return;
            }

            const { firstHalf, secondHalf } = rates[brand];
            const monthlyRateFirstHalf = firstHalf / 12;
            const monthlyRateSecondHalf = secondHalf / 12;
            const monthlyPaymentFirstHalf = (amount * monthlyRateFirstHalf) / (1 - Math.pow(1 + monthlyRateFirstHalf, -12));
            const monthlyPaymentSecondHalf = (amount * monthlyRateSecondHalf) / (1 - Math.pow(1 + monthlyRateSecondHalf, -12));
            const totalPayment = (monthlyPaymentFirstHalf * 12);
            const feeRate = 0.09;
            const totalFee = amount * feeRate;
            const finalRepaymentAmount = totalPayment + totalFee;

            document.getElementById("result").innerHTML = `
                <p>اقساط نیمه اول (12 ماه اول): ${monthlyPaymentFirstHalf.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} تومان</p>
                <p>اقساط نیمه دوم (12 ماه دوم): ${monthlyPaymentSecondHalf.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} تومان</p>
                <p>کارمزد: ${totalFee.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} تومان</p>
                <p>بازپرداخت نهایی: ${finalRepaymentAmount.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} تومان</p>
            `;
        }
    </script>
    <?php
    return ob_get_clean(); // Return the output buffer contents
}

// Shortcode for the general calculator
add_shortcode('vam', 'vam_installment_calculator');

// Shortcodes for specific brands
function vam_brand_shortcode($atts) {
    $atts = shortcode_atts(array(
        'brand' => '',
    ), $atts);

    return vam_installment_calculator($atts);
}

// Register brand specific shortcodes
add_shortcode('vam="pakshoma"', function() {
    return vam_brand_shortcode(['brand' => 'پاکشوما']);
});
add_shortcode('vam="maadiran"', function() {
    return vam_brand_shortcode(['brand' => 'مادیران']);
});

add_shortcode('vam="planton"', function() {
    return vam_brand_shortcode(['brand' => 'بلانتون']);
});

add_shortcode('vam="goldiran"', function() {
    return vam_brand_shortcode(['brand' => 'گلدیران']);
});

add_shortcode('vam="clever"', function() {
    return vam_brand_shortcode(['brand' => 'کلور']);
});

add_shortcode('vam="depoint"', function() {
    return vam_brand_shortcode(['brand' => 'دیپوینت']);
});

add_shortcode('vam="eroplus"', function() {
    return vam_brand_shortcode(['brand' => 'یوروپلاس']);
});

add_shortcode('vam="life"', function() {
    return vam_brand_shortcode(['brand' => 'لایف']);
});

add_shortcode('vam="tachno"', function() {
    return vam_brand_shortcode(['brand' => 'تاکنو']);
});

add_shortcode('vam="eroplus"', function() {
    return vam_brand_shortcode(['brand' => 'یوروپلاس']);
});
add_shortcode('vam="jsun"', function() {
    return vam_brand_shortcode(['brand' => 'جی سان']);
});


// Add more brand shortcodes as needed
