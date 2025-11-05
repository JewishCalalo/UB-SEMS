<?php ($tid = 'tb-' . \Illuminate\Support\Str::uuid()); ?>
<div id="<?php echo e($tid); ?>" class="relative z-10 flex items-center justify-between gap-3 mb-4">
	<div class="flex items-center gap-6">
		<label class="text-sm text-gray-700 font-medium">Rows per page:</label>
		<select name="per_page" onchange="this.form ? this.form.submit() : (window.location = updateQuery(window.location.href, { per_page: this.value }))" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
			<?php ($pp = (int) request('per_page', 15)); ?>
			<?php $__currentLoopData = [10,15,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($n); ?>" <?php echo e($pp === $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	</div>
	<div class="flex items-center gap-2">
		<?php echo e($slot ?? ''); ?>

	</div>
</div>

<script>
function updateQuery(url, params) {
	const u = new URL(url);
	Object.entries(params).forEach(([k,v]) => { u.searchParams.set(k, v); });
	return u.toString();
}
// Ensure parent containers do not clip the native select dropdown
(function(){
	const el = document.getElementById('<?php echo e($tid); ?>');
	if (!el) return;
	let p = el.parentElement;
	while (p) {
		const classes = p.className || '';
		if (classes.includes('overflow-hidden')) {
			p.classList.remove('overflow-hidden');
			p.style.overflow = 'visible';
			break;
		}
		p = p.parentElement;
	}
})();
</script>
<?php /**PATH C:\SEMSv26\resources\views/components/table-toolbar.blade.php ENDPATH**/ ?>