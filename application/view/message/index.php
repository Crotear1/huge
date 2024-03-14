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
        </tbody>
      </table>
    </div>
    <div class="col-10">
      <div class="card">
        <!-- Chat -->
        <div class="card-body" style="height: 500px; overflow-y: auto;">

        </div>
          <div>
            <form method="post" action="<?php echo Config::get('URL');?>message/create">
              <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-left: 10px; margin-right: 10px;">
                  <input type="text" class="form-control" id="message" name="message" placeholder="Nachricht eingeben" style="flex-grow: 1; margin-right: 10px;">
                  <button>Senden</button>
              </div>
            </form>
            <script>
                // Waits to load the DOM before running the script
                document.addEventListener('DOMContentLoaded', (event) => {
                let userId = undefined;

                // Get all buttons
                const buttons = document.querySelectorAll('.btn');

                let messages = [];

                // Function to render the messages
                function renderMessages() {
                    const cardBody = document.querySelector('.card-body');
                    cardBody.innerHTML = '';

                    messages.forEach((message) => {
                        const div = document.createElement('div');
                        div.innerHTML = message.message;

                        if(message.sender_id == userId) {
                            div.style.textAlign = 'right';
                            div.classList.add('text-right', 'bg-light');

                        } else {
                            div.style.textAlign = 'left';
                            div.classList.add('text-left', 'bg-success');
                        }
                        cardBody.appendChild(div);
                    });
                }

                // Add event listener to each button
                buttons.forEach((button) => {
                    button.addEventListener('click', (event) => {
                        // Get the user id from the button
                        userId = event.target.getAttribute('data-user-id'); // Set the user id to a variable
                        console.log(`Button clicked for user id: ${userId}`);

                        // todo - fetch the chat messages for the user id
                        fetch(`<?= Config::get('URL'); ?>message/getMessagesForUser/${userId}/<?= Session::get('user_id'); ?>`)
                            .then(response => response.json())
                            .then(data => {
                                messages = data;
                                console.log(data);
                                renderMessages();
                        });
                    });
                });

                document.querySelector('form').addEventListener('submit', function(event) {
                    event.preventDefault();

                    // Ihr Code zum Senden der Nachricht geht hier hin
                    let message = document.getElementById('message').value;
                    console.log(`Nachricht: ${message}`);
                    console.log(`Empfänger: ${userId}`)
                    console.log(`Sender: <?= Session::get('user_id'); ?>`);

                    if(message.length > 0 && userId !== undefined) {
                        fetch(`<?= Config::get('URL'); ?>message/create/${userId}/<?= Session::get('user_id'); ?>/${message}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                        });
                    }
                });
            });
            </script>
        </div>
    </div>
  </div>
</div>

<style>
  .discussion {
	max-width: 600px;
	margin: 0 auto;

	display: flex;
	flex-flow: column wrap;
}

.discussion > .bubble {
	border-radius: 1em;
	padding: 0.25em 0.75em;
	margin: 0.0625em;
	max-width: 50%;
}

.discussion > .bubble.sender {
	align-self: flex-start;
	background-color: cornflowerblue;
	color: #fff;
}
.discussion > .bubble.recipient {
	align-self: flex-end;
	background-color: #efefef;
}

.discussion > .bubble.sender.first { border-bottom-left-radius: 0.1em; }
.discussion > .bubble.sender.last { border-top-left-radius: 0.1em; }
.discussion > .bubble.sender.middle {
	border-bottom-left-radius: 0.1em;
 	border-top-left-radius: 0.1em;
}

.discussion > .bubble.recipient.first { border-bottom-right-radius: 0.1em; }
.discussion > .bubble.recipient.last { border-top-right-radius: 0.1em; }
.discussion > .bubble.recipient.middle {
	border-bottom-right-radius: 0.1em;
	border-top-right-radius: 0.1em;
}
  </style>
