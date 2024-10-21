const toggleCheck = document.getElementById('select_sale');
const amountSale = document.querySelector('.amount_sale');
const date = document.querySelector('.date');
const time = document.querySelector('.time');
let isChecked = false;

toggleCheck.addEventListener('change', function() {
    if (this.checked) {
        if (!isChecked) {
            if (window.innerWidth < 941) {
                amountSale.style.transform = 'translateX(-750px)';
                date.style.transform = 'translateX(-750px)';
                time.style.transform = 'translateX(-750px)';
            } else {
                amountSale.style.transform = 'translateX(-700px)';
                date.style.transform = 'translateX(-700px)';
                time.style.transform = 'translateX(-700px)';
            }
            isChecked = true;
        }
    } else {
        if (isChecked) {
            if (window.innerWidth < 941) {
                amountSale.style.transform = 'translateX(0)';
                date.style.transform = 'translateX(0)';
                time.style.transform = 'translateX(0)';
            } else {
                amountSale.style.transform = 'translateX(0)';
                date.style.transform = 'translateX(0)';
                time.style.transform = 'translateX(0)';
            }
            isChecked = false;
        }
    }
});


