// start delete confirmation
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".show_confirm").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            var url = this.getAttribute("href");
            swal({
                title: "Are you sure you want to delete this record?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.href = url;
                }
            });
        });
    });
});
// end delete confirmation
