const express = require('express');
const app = express();
const port = process.env.PORT || 9000; // ใช้ PORT จาก environment variables หรือ 9000 เป็นค่าเริ่มต้น

app.get('/', (req, res) => {
    res.send('Hello from Express!');
});

app.listen(port, '0.0.0.0', () => {
    console.log(`Server running at http://0.0.0.0:${port}`);
});
