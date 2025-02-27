<script>
    (function () {
        "use strict";
        var options = {}
        var notifier = new AWN(options);


        /* Confirmation notifications */
      // document.querySelector('#confirm').addEventListener('click', function () {
      //         notifier.confirm('Are you sure you want to reset the password')
      //     })

    })();
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        "use strict";

        var options = {}; // Customize if needed
        var notifier = new AWN(options);

        /* Confirmation Notification */
        document.querySelector('#confirm').addEventListener('click', function () {
            notifier.confirm(
                "Are you sure you want to reset the password?",
                function () {
                    alert("Password reset confirmed!"); // Replace with actual logic
                },
                function () {
                    console.log("User canceled the reset.");
                }
            );
        });

    });
</script>
