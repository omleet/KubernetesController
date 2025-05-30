<script>
    @if (!old('containers'))
    var containerCount = 0;
    @endif

    // These functions are overridden in create.blade.php
    // This is just a placeholder to prevent errors
    function appendInput(baseDivName, inputName) {
        // This function is overridden in create.blade.php
        console.log("Using original appendInput - this should be overridden");
    }

    function addPort(containerId) {
        // This function is overridden in create.blade.php
        console.log("Using original addPort - this should be overridden");
    }

    function addEnv(containerId) {
        // This function is overridden in create.blade.php
        console.log("Using original addEnv - this should be overridden");
    }

    // This event listener is also overridden
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('removeInput')) {
            // This is handled in create.blade.php
        }
    });
</script>