<?php
$page_name = $this->uri->segment(1) . '/' . $this->uri->segment(2);
$user = $this->session->userdata('user_id');
?>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables Tailwind -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<div class="w-full mx-auto bg-white shadow-md rounded-2xl p-6 mt-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Supplier List</h2>

        <a href="<?php echo base_url().'index.php/Supplier/add_supplier'; ?>"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + Add Supplier
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="supplierTable" class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th>#</th>
                    <th>Supplier Code</th>
                    <th>Supplier Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $i=1; foreach ($all_suppliers as $supplier) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $supplier->supplier_code; ?></td>
                    <td><?php echo $supplier->supplier_name; ?></td>
                    <td class="text-center">
                        <div class="flex justify-center gap-2">

                            <a href="<?php echo base_url().'index.php/Supplier/edit_supplier/'.$supplier->supplier_id; ?>"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                               Edit
                            </a>

                           
                            <a href="<?php echo base_url().'index.php/Supplier/delete_supplier/'.$supplier->supplier_id; ?>"
                               onclick="return confirm('Delete this supplier?')"
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
                               Delete
                            </a>
                            

                        </div>
                    </td>
                </tr>
                <?php $i++; } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#supplierTable').DataTable({
        pageLength: 10,
        responsive: true,
        autoWidth: false,
        language: {
            search: "🔍 Search Suppliers:",
            lengthMenu: "Show _MENU_ suppliers",
            info: "Showing _START_ to _END_ of _TOTAL_ suppliers",
            paginate: {
                previous: "←",
                next: "→"
            }
        }
    });
});
</script>
