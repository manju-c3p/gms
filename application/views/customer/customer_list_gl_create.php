<div class="flex justify-end mb-4">
    <button id="syncLedgerBtn"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
        Add All Customers to General Ledger
    </button>
</div>

<script>
document.getElementById('syncLedgerBtn').addEventListener('click', function () {

    if (!confirm('This will create ledger accounts for all customers. Continue?')) {
        return;
    }

    fetch("<?= base_url('index.php/Customer/sync_customers_to_ledger') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    })
    .catch(err => {
        alert('Something went wrong');
        console.error(err);
    });
});
</script>
