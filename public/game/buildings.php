<?php
$user = $_SESSION['user'];

use App\core\Context;

Context::getInstance()->buildingController->getBuildings($user->id);
$buildings = $_SESSION['buildings'];
?>
  <!-- ✅ Buildings Section -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-lg font-bold">🏠 Buildings</h2>
        <?php foreach ($buildings as $building): ?>
            <div class="mt-2 flex justify-between">
                <span><?= $building->name ?> (Lvl <?= $building->level ?? '0' ?>)</span>
                <span
                        class="text-red-400 countdown-timer"
                        data-endtime="<?= $building->endsBuildingAt->getTimestamp(); ?>"
                        data-building-id="<?= $building->building_id ?>"
                        data-level="<?= $building->level ?>"
                        data-name="<?= $building->name ?>"
                        data-description="<?= $building->description ?>"
                        data-image="<?= $building->image ?>"
                        data-wood="<?= $building->nextLevelCost->resources->wood ?>"
                        data-stone="<?= $building->nextLevelCost->resources->stone ?>"
                        data-food="<?= $building->nextLevelCost->resources->food ?>"
                        data-gold="<?= $building->nextLevelCost->resources->gold ?>"
                        data-time="<?= $building->nextLevelCost->time ?>"
                        data-production="<?= $building->nextLevelProduction ?>"
                >
        --
    </span>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- ✅ Upgrade Popup -->
    <div id="upgradePopup" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-gray-800 p-6 rounded-lg w-96 text-center relative">
            <button onclick="closePopup()" class="absolute top-2 right-2 text-white text-xl">&times;</button>
            <h2 id="popupName" class="text-xl font-bold"></h2>
            <img id="popupImage" class="w-40 mx-auto my-3" src="" alt="">
            <p id="popupDescription" class="text-sm text-gray-400"></p>

            <div class="mt-4">
                <h3 class="font-bold">🔧 Upgrade Cost to Level <span id="popupLevel"></span></h3>
                <p>⏳ Time: <span id="popupTime"></span>s</p>
                <p>🌲 Wood: <span id="popupWood"></span></p>
                <p>⛏ Stone: <span id="popupStone"></span></p>
                <p>🍞 Food: <span id="popupFood"></span></p>
                <p>💰 Gold: <span id="popupGold"></span></p>
            </div>

            <div class="mt-4">
                <h3 class="font-bold">📈 New Production</h3>
                <p>+<span id="popupProduction"></span></p>
            </div>

            <button id="confirmUpgrade" class="bg-green-500 px-4 py-2 rounded-lg mt-4">Confirm Upgrade</button>
        </div>
    </div>

    <script>
        function openUpgradePopup(id, level, name, description, image, wood, stone, food, gold, time, production) {
            document.getElementById('popupName').innerText = name;
            document.getElementById('popupLevel').innerText = level+1;
            document.getElementById('popupDescription').innerText = description;
            document.getElementById('popupImage').src = image;
            document.getElementById('popupTime').innerText = time;
            document.getElementById('popupWood').innerText = wood;
            document.getElementById('popupStone').innerText = stone;
            document.getElementById('popupFood').innerText = food;
            document.getElementById('popupGold').innerText = gold;
            document.getElementById('popupProduction').innerText = production;

            const cost = {
                resources: {
                    wood,
                    stone,
                    food,
                    gold
                },
                time
            }
            document.getElementById('confirmUpgrade').onclick = () => confirmUpgrade(id, level, cost, production);

            document.getElementById('upgradePopup').classList.remove('hidden');
        }

        function closePopup() {
            document.getElementById('upgradePopup').classList.add('hidden');
        }

        function confirmUpgrade(id, level, cost, production) {
            fetch('upgrade.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }, // Set JSON headers
                body: JSON.stringify({
                    building_id: id,
                    level,
                    cost,
                    production})
            })
                .then(() => {
                    closePopup();
                    location.reload(); // Refresh the page to update the building level
                });
        }

        function startCountdown() {
            const timers = document.querySelectorAll('.countdown-timer');
            timers.forEach(timer => {
                const endTime = parseInt(timer.getAttribute('data-endtime')) * 1000; // Convert to milliseconds
                const parentDiv = timer.parentElement; // The div that contains the timer & upgrade button
                const buildingId = timer.getAttribute('data-building-id'); // Get the building ID
                const intervalId = setInterval(updateTimer, 1000); // ✅ Store interval ID
                updateTimer(); // Run immediately

                function updateTimer() {
                    const now = new Date().getTime();
                    const timeLeft = endTime - now;

                    if (timeLeft <= 0) {
                        clearInterval(intervalId);
                        timer.remove(); // Remove countdown timer

                        // ✅ Ensure only one "Upgrade" button is added
                        if (!parentDiv.querySelector('.upgrade-button')) {
                            const upgradeButton = document.createElement("a");
                            upgradeButton.href = "#";
                            upgradeButton.classList.add("text-green-400", "upgrade-button"); // Add a class to prevent duplicates
                            upgradeButton.innerText = "Upgrade";
                            upgradeButton.onclick = function () {
                                openUpgradePopup(
                                    buildingId,
                                    parseInt(timer.getAttribute('data-level')),
                                    timer.getAttribute('data-name'),
                                    timer.getAttribute('data-description'),
                                    timer.getAttribute('data-image'),
                                    parseInt(timer.getAttribute('data-wood')),
                                    parseInt(timer.getAttribute('data-stone')),
                                    parseInt(timer.getAttribute('data-food')),
                                    parseInt(timer.getAttribute('data-gold')),
                                    parseInt(timer.getAttribute('data-time')),
                                    parseInt(timer.getAttribute('data-production'))
                                );
                            };

                            parentDiv.appendChild(upgradeButton); // Add "Upgrade" button
                        }
                        return;
                    }

                    // ⏳ Convert timeLeft into MM:SS format
                    const minutes = Math.floor((timeLeft / 1000 / 60) % 60);
                    const seconds = Math.floor((timeLeft / 1000) % 60);

                    timer.innerText =
                        (minutes < 10 ? "0" : "") + minutes + ":" +
                        (seconds < 10 ? "0" : "") + seconds;
                }
            });
        }

        document.addEventListener("DOMContentLoaded", startCountdown);

    </script>
