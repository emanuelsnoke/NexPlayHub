<x-app-layout>
    <div class="container">
        <aside class="sidebar">
            <div class="profile-section" onclick="toggleProfileMenu()">
                <div class="profile-icon">👤</div>
                <div id="userName">{{ Auth::user()->name }}</div>
            </div>
            <div class="profile-menu" id="profileMenu">
                <a href="#">Perfil</a>
                <a href="#">Configurações</a>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sair
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
            <ul>
                <li onclick="mostrarFeed()"> Início</li>
                <li onclick="mostrarJogos()">Jogos</li>
                <li>Amigos</li>
                <li>Comunidades</li>
                <li>Grupos</li>
                <button id="clearPostsBtn">Apagar todos os posts</button>
            </ul>
        </aside>

        <div class="main-content">
            <header class="navbar">
                <h4>NexPlayHub</h4>
            </header>

            <!-- FEED -->
            <section id="feedSection" class="feed">
                <form onsubmit="event.preventDefault(); addPost();">
                    <div class="new-post">
                        <textarea id="postText" placeholder="O que você está pensando?"></textarea>
                        <input type="file" id="postFile" accept="image/*,video/*,.pdf,.doc,.docx" />
                        <button type="submit">Publicar</button>
                    </div>
                </form>
                <div id="postsContainer"></div>
            </section>

            <!-- JOGOS -->
            <section id="jogosSection" class="hidden">
                <!-- Galeria de Jogos -->
                <div id="gameGallery" style="display: flex; flex-wrap: wrap; gap: 16px;">
                    <div class="game-card" onclick="iniciarJogo('PKEMR.gba')" style="cursor: pointer;">
                        <img src="/jogos/gba/imagens/pokemon.jpeg" alt="Pokémon" style="width: 150px; height: 150px; object-fit: cover;">
                        <p style="text-align: center;">Pokémon Emerald</p>
                    </div>
                    <div class="game-card" onclick="iniciarJogo('Super Mario Advance 2 - Super Mario World.gba')" style="cursor: pointer;">
                        <img src="/jogos/gba/imagens/mario.jpeg" alt="Mario" style="width: 150px; height: 150px; object-fit: cover;">
                        <p style="text-align: center;">Mario World</p>
                    </div>
                </div>

                <!-- Emulador -->
                <div id="gameContainer" style="margin-top: 20px;">
                    <canvas id="emulator_canvas" width="480" height="320" style="border: 2px solid black;"></canvas>
                </div>
            </section>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/iodine-gba@2.0.1/IodineGBA.js"></script>
    <script>
        let iodine;

        function iniciarJogo(nomeRom) {
            console.log("Iniciando jogo:", nomeRom);

            if (!iodine) {
                iodine = new IodineGBA();
                iodine.attachCanvas(document.getElementById("emulator_canvas"));
            } else {
                iodine.stop();
            }

            fetch(`/jogos/gba/roms/${nomeRom}`)
                .then(response => response.arrayBuffer())
                .then(buffer => {
                    const romData = new Uint8Array(buffer);
                    iodine.attachROM(romData);
                    iodine.play();
                })
                .catch(err => console.error("Erro ao carregar ROM:", err));
        }

        function mostrarJogos() {
            document.getElementById('feedSection').classList.add('hidden');
            document.getElementById('jogosSection').classList.remove('hidden');
        }

        function mostrarFeed() {
            document.getElementById('feedSection').classList.remove('hidden');
            document.getElementById('jogosSection').classList.add('hidden');
        }
    </script>
</x-app-layout>
