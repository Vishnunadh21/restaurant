document.getElementById('reserveButton').addEventListener('click', function() {
    if (!selectedTable) return;

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;
    const guests = document.getElementById('guests').value;

    fetch('reserve.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            name: name,
            email: email,
            phone: phone,
            table_id: selectedTable,
            date: date,
            time: time,
            guests: guests
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);
            document.querySelector(`.table[data-id="${selectedTable}"]`).classList.add('reserved');
            selectedTable = null;
            document.querySelectorAll('input, select').forEach(el => el.value = '');
            updateSummary();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
