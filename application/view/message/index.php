<div class="container">
  <div class="row">
    <div class="col-2">
      <table class="table">
        <tbody>
        <?php foreach ($this->users as $user) { ?>
          <tr>
            <td><button class="btn" style="width: 120px;" data-user-id="<?= $user->user_id; ?>"><?= $user->user_name; ?></button></td>
          </tr>
        <?php } ?>
        <script>
            // Waits to load the DOM before running the script
            document.addEventListener('DOMContentLoaded', (event) => {
                // Get all buttons
                const buttons = document.querySelectorAll('.btn');

                // Add event listener to each button
                buttons.forEach((button) => {
                    button.addEventListener('click', (event) => {
                        // Get the user id from the button
                        const userId = event.target.getAttribute('data-user-id');
                        console.log(`Button clicked for user id: ${userId}`);

                        // todo - fetch the chat messages for the user id
                        <?php echo "fetch('" . Config::get('URL') . "message/getMessagesForUser/' + userId, { method: 'GET' })" ?>
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                    });
                });
            });
        </script>
        </tbody>
      </table>
    </div>
    <div class="col-10">
      <div class="card">
        <div class="card-body" style="height: 500px; overflow-y: auto;">
          <h5 class="card-title">Chat</h5>
          <p class="card-text">Chat Inhalt</p>
        </div>
      </div>
    </div>
  </div>
</div>
