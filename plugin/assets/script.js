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
    calculate(); // Call calculate when slider changes
}

// Call calculate when the page loads to show default calculation
window.onload = function () {
    calculate();
}

function calculate() {
    const amount = parseFloat(document.getElementById("requestedAmount").value);
    const brand = document.getElementById("brand").value;
    const n = parseInt(document.getElementById("duration").value); // تعداد اقساط

    if (isNaN(amount) || amount <= 0 || n <= 0) {
        document.getElementById("result").innerText = "";
        return;
    }

    const { firstHalf, secondHalf } = rates[brand];

    const monthlyRateFirstHalf = firstHalf / 12; // نرخ بهره ماهانه نیمه اول
    const monthlyRateSecondHalf = secondHalf / 12; // نرخ بهره ماهانه نیمه دوم

    // محاسبه قسط نیمه اول
    const monthlyPaymentFirstHalf = (amount * monthlyRateFirstHalf) / (1 - Math.pow(1 + monthlyRateFirstHalf, -12));
    // محاسبه قسط نیمه دوم
    const monthlyPaymentSecondHalf = (amount * monthlyRateSecondHalf) / (1 - Math.pow(1 + monthlyRateSecondHalf, -12));

    // محاسبه کل پرداختی
    const totalPayment = (monthlyPaymentFirstHalf * 12);

    // محاسبه کارمزد 9 درصد
    const feeRate = 0.09; // کارمزد 9 درصد
    const totalFee = amount * feeRate; // کل کارمزد

    // محاسبه بازپرداخت نهایی
    const finalRepaymentAmount = totalPayment + totalFee; // بازپرداخت نهایی

    document.getElementById("result").innerHTML = `
        <p>اقساط نیمه اول (12 ماه اول): ${Math.round(monthlyPaymentFirstHalf).toLocaleString()} تومان</p>
        <p>اقساط نیمه دوم (12 ماه دوم): ${Math.round(monthlyPaymentSecondHalf).toLocaleString()} تومان</p>
        <p>کارمزد: ${Math.round(totalFee).toLocaleString()} تومان</p>
        <p>بازپرداخت نهایی: ${Math.round(finalRepaymentAmount).toLocaleString()} تومان</p>
    `;
}