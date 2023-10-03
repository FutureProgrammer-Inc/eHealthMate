<!-- Add this code at the end of your HTML body -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display the session message here -->
                <p id="messageContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Check if there is a message in the session
    <?php if (!empty($_SESSION['message'])) : ?>
        // Set the message content and show the modal
        var messageContent = "<?php echo $_SESSION['message']; ?>";
        $("#messageContent").text(messageContent);
        $("#messageModal").modal("show");
        // Remove the message from the session
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</script>