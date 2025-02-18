<script>
        // Declare arrays as global variables
        window.element = ["p", "div", "img", "h1", "h2", "h3", "h4", "h5", "h6"];
        window.config = ["top", "bottom", "center"];

    function addElementAtIndex(arr, index, element) {
        arr.splice(index, 0, element); // Insert the element at the specified index
        console.log(arr.join()); // Log the modified array
    }
    // Example usage:

    // Add top element at start
    addElementAtIndex(window.element, 0, window.config[0]);
    // Add center element after each existing element
    for(var i = 2; i < window.element.length; i+=2) {
        addElementAtIndex(window.element, i, window.config[2]);
    }
    // Add bottom element at end
    addElementAtIndex(window.element, window.element.length, window.config[1]);

    console.log("Final array:", window.element);
</script>
