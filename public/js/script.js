
    // sort low high new

    // เลือกปุ่มทั้งหมดในกล่อง toggle
    const buttons = document.querySelectorAll('.toggle .sort button');

    // ตัวแปรสำหรับเก็บปุ่มที่ถูกเลือก
    let selectedButton = null;

    // ฟังก์ชันสำหรับการกำหนดสีให้กับปุ่ม
    function setActiveButton(button) {
        // ตรวจสอบว่ามีปุ่มที่ถูกเลือกอยู่หรือไม่
        if (selectedButton) {
            // ถ้ามีปุ่มที่ถูกเลือกอยู่ ให้ลบ class 'active' ออก
            selectedButton.classList.remove('active');
        }
        // กำหนดปุ่มที่ถูกเลือกใหม่
        selectedButton = button;
        // เพิ่ม class 'active' เข้าไปในปุ่มที่ถูกเลือก
        selectedButton.classList.add('active');
    }

    // วนลูปผ่านปุ่มทั้งหมด
    buttons.forEach(button => {
        // เพิ่ม event listener เมื่อปุ่มถูกคลิก
        button.addEventListener('click', () => {
            // เรียกใช้ฟังก์ชัน setActiveButton เพื่อกำหนดสีให้กับปุ่มที่ถูกเลือก
            setActiveButton(button);
        });
    });



    const toggleCheckbox1 = document.getElementById('toggleCheckbox1');
    const toggleDiv1 = document.querySelector('#toggle-1');
    toggleCheckbox1.addEventListener('change', function() {
        if (toggleCheckbox1.checked) {
            toggleDiv1.style.display = 'flex';
        } else {
            toggleDiv1.style.display = 'none';
        }
    });

    const toggleCheckbox2 = document.getElementById('toggleCheckbox2');
    const toggleDiv2 = document.querySelector('#toggle-2');
    toggleCheckbox2.addEventListener('change', function() {
        if (toggleCheckbox2.checked) {
            toggleDiv2.style.display = 'flex';
        } else {
            toggleDiv2.style.display = 'none';
        }
    });

    const toggleCheckbox3 = document.getElementById('toggleCheckbox3');
    const toggleDiv3 = document.querySelector('#toggle-3');
    toggleCheckbox3.addEventListener('change', function() {
        if (toggleCheckbox3.checked) {
            toggleDiv3.style.display = 'flex';
        } else {
            toggleDiv3.style.display = 'none';
        }
    });

    const toggleCheckbox4 = document.getElementById('toggleCheckbox4');
    const toggleDiv4 = document.querySelector('#toggle-4');
    toggleCheckbox4.addEventListener('change', function() {
        if (toggleCheckbox4.checked) {
            toggleDiv4.style.display = 'flex';
        } else {
            toggleDiv4.style.display = 'none';
        }
    });

    const toggleCheckbox1_mobile = document.getElementById('toggleCheckbox1_mobile');
    const toggleDiv1_mobile = document.querySelector('#toggle-1_mobile');
    toggleCheckbox1_mobile.addEventListener('change', function() {
        if (toggleCheckbox1_mobile.checked) {
            toggleDiv1_mobile.style.display = 'flex';
        } else {
            toggleDiv1_mobile.style.display = 'none';
        }
    });

    const toggleCheckbox2_mobile = document.getElementById('toggleCheckbox2_mobile');
    const toggleDiv2_mobile = document.querySelector('#toggle-2_mobile');
    toggleCheckbox2_mobile.addEventListener('change', function() {
        if (toggleCheckbox2_mobile.checked) {
            toggleDiv2_mobile.style.display = 'flex';
        } else {
            toggleDiv2_mobile.style.display = 'none';
        }
    });

    const toggleCheckbox3_mobile = document.getElementById('toggleCheckbox3_mobile');
    const toggleDiv3_mobile = document.querySelector('#toggle-3_mobile');
    toggleCheckbox3_mobile.addEventListener('change', function() {
        if (toggleCheckbox3_mobile.checked) {
            toggleDiv3_mobile.style.display = 'flex';
        } else {
            toggleDiv3_mobile.style.display = 'none';
        }
    });

    const toggleCheckbox4_mobile = document.getElementById('toggleCheckbox4_mobile');
    const toggleDiv4_mobile = document.querySelector('#toggle-4_mobile');
    toggleCheckbox4_mobile.addEventListener('change', function() {
        if (toggleCheckbox4_mobile.checked) {
            toggleDiv4_mobile.style.display = 'flex';
        } else {
            toggleDiv4_mobile.style.display = 'none';
        }
    });


    const inputCheckboxes = document.querySelectorAll('.content1 input[type="checkbox"]');

    inputCheckboxes.forEach(inputCheckbox => {
        inputCheckbox.addEventListener('click', function(event) {
            event.stopPropagation(); // หยุด propagation เพื่อไม่ให้กระจายไปยัง .box ใน content2
        });
    });


    // Amount price

    // สร้างตัวแปรที่มีค่าที่ต้องการแสดงใน HTML
    let amount_1 = 1000;
    let amount_2 = 100000000;
    let amount_3 = 2000;
    let amount_4 = 500000; // สมมติว่ามีค่าเท่ากับ 1000

    // ดึง element จาก HTML โดยใช้ ID
    const amountSpan1 = document.getElementById("amount-1");
    const amountSpan2 = document.getElementById("amount-2");
    const amountSpan3 = document.getElementById("amount-3");
    const amountSpan4 = document.getElementById("amount-4");
    // ฟังก์ชันสำหรับการอัปเดตค่าใน <span>
    function updateAmount() {
        amountSpan1.textContent = amount_1;
        amountSpan2.textContent = amount_2;
        amountSpan3.textContent = amount_3;
        amountSpan4.textContent = amount_4;
    }

    // เรียกใช้ฟังก์ชันเพื่อแสดงค่าเริ่มต้น
    updateAmount();
