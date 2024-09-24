<?php
/**
 * Plugin Name: Loan Calculator
 * Description: A custom loan calculator with installment plans.
 * Version: 1.0
 * Author: Your Name
 */

// اضافه کردن استایل‌ها و اسکریپت‌های پلاگین
function loan_calculator_enqueue_scripts() {
    wp_enqueue_style('loan-calculator-styles', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('loan-calculator-script', plugin_dir_url(__FILE__) . 'assets/script.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'loan_calculator_enqueue_scripts');

// شورت‌کد برای نمایش فرم محاسبه اقساط
function loan_calculator_shortcode() {
    ob_start();
    ?>
    <div class="container">
        <div>
            <h1>محاسبه اقساط</h1>

            <div class="form-group">
                <label for="requestedAmount">مبلغ درخواستی (۵ میلیون تا ۱۲۰ میلیون):</label>
                <input class="slider-fu" type="range" id="amountSlider" min="5000000" max="120000000" step="5000000"
                    value="0" oninput="updateAmount()">
                <div class="slider-value" id="sliderValue">۵,۰۰۰,۰۰۰ تومان</div>
            </div>

            <div class="form-group">
                <label for="customAmount">یا مبلغ دلخواه:</label>
                <input type="number" value="5000000"  id="requestedAmount" placeholder="مبلغ دلخواه را وارد کنید" oninput="calculate()">
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
                    <option value="پاکشوما">پاکشوما</option>
                    <option value="مادیران">مادیران</option>
                    <option value="بلانتون">بلانتون</option>
                    <option value="گلدیران">گلدیران</option>
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
        </div>

        <div class="result" id="result"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('loan_calculator', 'loan_calculator_shortcode');
