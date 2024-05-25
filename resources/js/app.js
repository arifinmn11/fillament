document.addEventListener("DOMContentLoaded", function () {
    const nodeId = localStorage.getItem("selectedNode");
    if (nodeId) {
        const nodeInput = document.querySelector('input[name="node_id"]');
        if (nodeInput) {
            nodeInput.value = nodeId;
        }
    }
});
