<?php $sl = 1; foreach ($customers as $c): ?>
<tr class="border-b hover:bg-gray-50">
	<td class="p-3"><?= $sl++; ?></td>
	<td class="p-3 font-medium"><?= $c->name ?></td>
	<td class="p-3"><?= $c->phone ?></td>
	<td class="p-3"><?= $c->email ?></td>
	<td class="p-3"><?= $c->address ?></td>
	<td class="p-3 text-center">
		<a href="<?= base_url('index.php/Customer/edit/'.$c->customer_id) ?>"
		   class="text-blue-600">Edit</a>
		   	<a onclick="return confirm('Delete this customer?');"
								href="<?= base_url('index.php/Customer/delete/' . $c->customer_id); ?>"
								class="p-2 rounded bg-red-100 hover:bg-red-200"
								title="Delete"
								class="text-blue-600">Delete</a>
							
	</td>
</tr>
<?php endforeach; ?>

<?php if (empty($customers)): ?>
<tr>
	<td colspan="6" class="p-4 text-center text-gray-500">
		No customers found
	</td>
</tr>
<?php endif; ?>
