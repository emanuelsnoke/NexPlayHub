<x-app-layout>
    <div class="container">
        <aside class="sidebar">
            <div class="profile-section">
                <div class="profile-icon">👤</div>
                <div id="userName">{{ Auth::user()->name }}</div>
            </div>
            <ul>
                <li><a href="{{ route('dashboard') }}">🏠 Voltar ao Início</a></li>
                <li><a href="#">⚙️ Configurações</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <header class="navbar">
                <h4>Perfil de {{ Auth::user()->name }}</h4>
            </header>

            <section class="profile-info" style="margin-bottom: 20px;">
                <h2>Bio</h2>
                <p>{{ Auth::user()->bio ?? 'Você ainda não escreveu uma bio.' }}</p>
                <!-- Pode adicionar um botão "Editar Bio" aqui futuramente -->
            </section>

            <section class="profile-stats" style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div><strong>Seguidores:</strong> {{ $seguidores }}</div>
                <div><strong>Seguindo:</strong> {{ $seguindo }}</div>
            </section>

            <section class="comunidades" style="margin-bottom: 20px;">
                <h3>Comunidades</h3>
                <ul>
                    @forelse($comunidades as $comunidade)
                        <li>{{ $comunidade->nome }}</li>
                    @empty
                        <li>Você ainda não participa de nenhuma comunidade.</li>
                    @endforelse
                </ul>
            </section>

            <section class="jogos-recentes" style="margin-bottom: 20px;">
                <h3>Jogos Jogados Recentemente</h3>
                <ul>
                    @forelse($jogosRecentes as $jogo)
                        <li>{{ $jogo->titulo }}</li>
                    @empty
                        <li>Nenhum jogo jogado recentemente.</li>
                    @endforelse
                </ul>
            </section>

            <section class="meus-posts">
                <h3>Meus Posts</h3>
                @forelse($meusPosts as $post)
                    <div class="post-card" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <p>{{ $post->conteudo }}</p>
                        @if($post->midia)
                            <img src="{{ asset('storage/' . $post->midia) }}" style="max-width: 100%;">
                        @endif
                    </div>
                @empty
                    <p>Você ainda não postou nada.</p>
                @endforelse
            </section>
        </div>
    </div>
</x-app-layout>
