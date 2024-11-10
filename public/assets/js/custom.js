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

    // Check if sidebar state is stored in localStorage
    if (localStorage.getItem("sidebarState") === "collapsed") {
        document.getElementById("sidebar").classList.add("collapsed");
        document.getElementById("main-content").classList.add("expanded");
        document
            .getElementById("header-navbar")
            .classList.add("expanded-header");
        document
            .getElementById("toggle-sidebar")
            .classList.add("collapsed-position");
    }

    document
        .getElementById("toggle-sidebar")
        .addEventListener("click", function () {
            // Toggle classes
            document.getElementById("sidebar").classList.toggle("collapsed");
            document
                .getElementById("main-content")
                .classList.toggle("expanded");
            document
                .getElementById("header-navbar")
                .classList.toggle("expanded-header");
            document
                .getElementById("toggle-sidebar")
                .classList.toggle("collapsed-position");

            // Save the state of the sidebar in localStorage
            if (
                document
                    .getElementById("sidebar")
                    .classList.contains("collapsed")
            ) {
                localStorage.setItem("sidebarState", "collapsed");
            } else {
                localStorage.setItem("sidebarState", "expanded");
            }
        });
});
// end delete confirmation
