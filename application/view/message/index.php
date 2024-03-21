<div class="container">
  <div style="text-align: right; margin-bottom: 15px;">
    <!-- Button to reload the messages -->
    <button type="button" class="btn btn-secondary" id="reload" >Lade Nachrichten</button>
  </div>
  <div class="row">
    <div class="col-2">
    <div class="btn-group-vertical" role="group" aria-label="User buttons">
      <?php foreach ($this->users as $user) { ?>
          <button class="chat-btn btn btn-secondary" style="width: 150px;" data-user-id="<?= $user->user_id; ?>">
              <?= $user->user_name; ?>
              <?php foreach ($this->getUnreadMessages as $unread) { ?>
                  <?php if($unread->sender_id == $user->user_id) { ?>
                      <span class="badge badge-primary"><?= $unread->unread; ?></span>
                  <?php } ?>
              <?php } ?>
          </button>
      <?php } ?>
    </div>
    </div>
    <div class="col-10">
      <div class="card">
        <div class="card-header">
          Chat mit <span id="chatName" ></span>
        </div>
        <!-- Chat -->
        <div class="card-body" style="height: 500px; overflow-y: auto;">

        </div>
          <div>
            <form method="post" action="<?php echo Config::get('URL');?>message/create">
              <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-left: 10px; margin-right: 10px;">
                  <input type="text" class="form-control" id="message" name="message" placeholder="Nachricht eingeben" style="flex-grow: 1; margin-right: 10px;">
                  <button class="btn btn-secondary" >Senden</button>
              </div>
            </form>
            <script>
                // Waits to load the DOM before running the script
                document.addEventListener('DOMContentLoaded', (event) => {
                let userId = undefined;

                // Get the chat name
                let chatName = document.getElementById('chatName');

                // Get all chat buttons
                const buttons = document.querySelectorAll('.chat-btn');

                // Get the reload button
                const reloadButton = document.getElementById('reload');

                let messages = [];

                /**
                 * Render the messages
                 * @returns void
                 */
                function renderMessages() {
                  const cardBody = document.querySelector('.card-body');
                  cardBody.innerHTML = '';

                  messages.forEach((message) => {
                      const div = document.createElement('div');
                      const p = document.createElement('p');
                      p.innerHTML = message.message;
                      p.classList.add('mb-0');

                      if(message.sender_id == userId) {
                          div.classList.add('d-flex', 'justify-content-start', 'my-1');
                          p.classList.add('py-2', 'px-3', 'rounded', 'bg-primary', 'text-white');
                      } else {
                          div.classList.add('d-flex', 'justify-content-end', 'my-1');
                          p.classList.add('py-2', 'px-3', 'rounded', 'bg-light');
                      }

                      div.appendChild(p);
                      cardBody.appendChild(div);
                  });

                  // Scroll to the bottom of the chat
                  cardBody.scrollTop = cardBody.scrollHeight;
              }

                reloadButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    getMessages();
                });

                function getMessages() {
                    fetch(`<?= Config::get('URL'); ?>message/getMessagesForUser/${userId}/<?= Session::get('user_id'); ?>`)
                        .then(response => response.json())
                        .then(data => {
                            messages = data;
                            renderMessages();
                          console.log(data);
                    });
                }

                // Add event listener to each button
                buttons.forEach((button) => {
                    button.addEventListener('click', (event) => {
                        // Get the user id from the button
                        userId = event.target.getAttribute('data-user-id'); // Set the user id to a variable
                        chatName.innerHTML = event.target.innerHTML; // Set the chat name
                        getMessages()
                        <?php foreach ($this->getUnreadMessages as $unread) { ?>
                            if(userId == <?= $unread->sender_id; ?>) {
                                event.target.querySelector('span').remove();
                            }
                        <?php } ?>
                    });
                });


                document.querySelector('form').addEventListener('submit', function(event) {
                    event.preventDefault();

                    let message = document.getElementById('message').value;

                    if(message.length > 0 && userId !== undefined) {
                        fetch(`<?= Config::get('URL'); ?>message/create/${userId}/<?= Session::get('user_id'); ?>/${message}`)
                        getMessages();

                        document.getElementById('message').value = '';
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
