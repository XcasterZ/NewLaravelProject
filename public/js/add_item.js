const actualBtn = document.getElementById('actual-btn');

const fileChosen = document.getElementById('file-chosen');

actualBtn.addEventListener('change', function () {
    fileChosen.textContent = this.files[0].name
})

const actualBtn2 = document.getElementById('actual-btn2');

const fileChosen2 = document.getElementById('file-chosen2');

actualBtn2.addEventListener('change', function () {
    fileChosen2.textContent = this.files[0].name
})

const actualBtn3 = document.getElementById('actual-btn3');

const fileChosen3 = document.getElementById('file-chosen3');

actualBtn3.addEventListener('change', function () {
    fileChosen3.textContent = this.files[0].name
})

const actualBtn4 = document.getElementById('actual-btn4');

const fileChosen4 = document.getElementById('file-chosen4');

actualBtn4.addEventListener('change', function () {
    fileChosen4.textContent = this.files[0].name
})

const actualBtn5 = document.getElementById('actual-btn5');

const fileChosen5 = document.getElementById('file-chosen5');

actualBtn5.addEventListener('change', function () {
    fileChosen5.textContent = this.files[0].name
})

document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const fileInput = document.getElementById(targetId);
            const fileChosenSpan = document.querySelector(`#file-chosen${targetId.replace('actual-btn', '')}`);

            if (fileInput) {
                fileInput.value = ''; // Clear the file input
            }

            if (fileChosenSpan) {
                fileChosenSpan.textContent = 'No file chosen'; // Update the span text
            }
        });
    });

    const saleCheckbox = document.getElementById('select_sale');
    const dateInput = document.getElementById('select_date');
    const timeInput = document.getElementById('select_time');
    const quantityInput = document.querySelector('input[name="quantity"]');
    const imgVdo1Input = document.getElementById('actual-btn');


    saleCheckbox.checked = false;

    saleCheckbox.addEventListener('change', function () {
        if (this.checked) {
            dateInput.disabled = false;
            timeInput.disabled = false;
            quantityInput.disabled = true;
            quantityInput.value = '';
            dateInput.required = true;
            timeInput.required = true;
            quantityInput.required = false;
        } else {
            dateInput.disabled = true;
            timeInput.disabled = true;
            dateInput.value = '';
            timeInput.value = '';
            quantityInput.disabled = false;
            dateInput.required = false;
            timeInput.required = false;
            quantityInput.required = true;
        }
    });
});