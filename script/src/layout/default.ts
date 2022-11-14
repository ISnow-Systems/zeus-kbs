const toasts: { [props: string]: string } = {};
$(() => {
	const toastConainer = $("#toast-container");

	function showToast(body: string, header?: string, check_id?: string) {
		const toastEle = "toast-" + (new Date()).getTime();
		$(
			`<div id="${toastEle}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			${(header !== undefined ? `<div class="toast-header">${header}</div>` : "")}
			<div class="toast-body">${body}</div>
			</div>`
		).appendTo(toastConainer);
		const jqToastEle = $("#" + toastEle);
		const toast = new bootstrap.Toast(jqToastEle[0])
		jqToastEle.on('hidden.bs.toast', () => {
			if (check_id != undefined) delete toasts[check_id];
			toast.dispose();
			jqToastEle.remove();
		})
		if (check_id != undefined && typeof (toasts[check_id]) == "string") {
			const toast2 = new bootstrap.Toast($("#" + toasts[check_id])[0])
			toast2.hide();
			delete toasts[check_id];
		}
		if (check_id != undefined) toasts[check_id] = toastEle;
		toast.show()
	}
});
