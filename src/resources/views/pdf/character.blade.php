<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Ficha — {{ $c->name }}</title>
<style>
    * { box-sizing: border-box; }
    body { font-family: DejaVu Sans, Arial, sans-serif; color: #1a1a1a; font-size: 11px; margin: 0; padding: 18px 22px; }
    h1 { font-size: 20px; margin: 0 0 2px; }
    h2 { font-size: 13px; margin: 14px 0 4px; border-bottom: 2px solid #8a6d1f; padding-bottom: 2px; color: #6b540f; text-transform: uppercase; letter-spacing: 0.5px; }
    .sub { color: #555; font-size: 11px; margin-bottom: 8px; }
    table { width: 100%; border-collapse: collapse; }
    td, th { padding: 2px 5px; text-align: left; vertical-align: top; }
    .grid td { width: 16.66%; border: 1px solid #ccc; text-align: center; }
    .grid .lbl { font-size: 9px; color: #777; text-transform: uppercase; }
    .grid .val { font-size: 16px; font-weight: bold; }
    .stats td { border: 1px solid #ccc; text-align: center; width: 25%; }
    .skills td { border-bottom: 1px solid #eee; }
    .skills .b { text-align: right; font-weight: bold; width: 36px; }
    .na { color: #999; }
    .tag { font-size: 8px; background: #efe3c0; color: #6b540f; padding: 0 3px; border-radius: 2px; }
    .lined th { border-bottom: 1px solid #8a6d1f; font-size: 9px; text-transform: uppercase; color: #6b540f; }
    .lined td { border-bottom: 1px solid #eee; }
    .muted { color: #666; }
    .pill { display: inline-block; border: 1px solid #8a6d1f; border-radius: 8px; padding: 1px 7px; font-size: 10px; }
    .two-col { width: 100%; }
    .two-col td { width: 50%; vertical-align: top; }
</style>
</head>
<body>

    <h1>{{ $c->name }}</h1>
    <div class="sub">
        {{ $c->characterClass->name ?? '—' }} •
        {{ $c->race->name ?? '—' }} •
        Nível {{ $c->total_level }}
        @if($c->origin) • Origem: {{ $c->origin->name }} @endif
        @if($c->deity) • Devoto de {{ $c->deity }} @endif
    </div>

    {{-- Recursos --}}
    <table class="grid">
        <tr>
            <td><div class="lbl">PV</div><div class="val">{{ $c->current_hp ?? $c->max_hp }}/{{ $c->max_hp }}</div></td>
            <td><div class="lbl">PM</div><div class="val">{{ $c->current_mp ?? $c->max_mp }}/{{ $c->max_mp }}</div></td>
            <td><div class="lbl">Defesa</div><div class="val">{{ $c->defense }}</div></td>
            <td><div class="lbl">Deslocamento</div><div class="val">{{ $c->displacement ?? '9m' }}</div></td>
            <td><div class="lbl">Tamanho</div><div class="val">{{ $c->size ?? 'Médio' }}</div></td>
            @if($c->spell_dc)
                <td><div class="lbl">CD Magia</div><div class="val">{{ $c->spell_dc['value'] }}</div></td>
            @else
                <td><div class="lbl">T$</div><div class="val">{{ $c->money_gold }}</div></td>
            @endif
        </tr>
    </table>

    {{-- Atributos --}}
    <h2>Atributos</h2>
    <table class="stats">
        <tr>
            <td><div class="lbl">FOR</div><b>{{ sprintf('%+d', $c->strength) }}</b></td>
            <td><div class="lbl">DES</div><b>{{ sprintf('%+d', $c->dexterity) }}</b></td>
            <td><div class="lbl">CON</div><b>{{ sprintf('%+d', $c->constitution) }}</b></td>
            <td><div class="lbl">INT</div><b>{{ sprintf('%+d', $c->intelligence) }}</b></td>
        </tr>
        <tr>
            <td><div class="lbl">SAB</div><b>{{ sprintf('%+d', $c->wisdom) }}</b></td>
            <td><div class="lbl">CAR</div><b>{{ sprintf('%+d', $c->charisma) }}</b></td>
            <td colspan="2"></td>
        </tr>
    </table>

    <table class="two-col"><tr>
    <td>
        {{-- Perícias --}}
        <h2>Perícias</h2>
        <table class="skills">
            @foreach($c->skills as $s)
                <tr>
                    <td>
                        {{ $s['skill'] }}
                        @if($s['trained']) <span class="tag">T</span> @endif
                        @if($s['trained_only']) <span class="tag">ST</span> @endif
                    </td>
                    <td class="b">
                        @if($s['usable']) {{ sprintf('%+d', $s['total']) }} @else <span class="na">—</span> @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </td>
    <td>
        {{-- Ataques --}}
        <h2>Ataques</h2>
        @if(count($c->attacks))
        <table class="lined">
            <tr><th>Arma</th><th>Ataque</th><th>Dano</th><th>Crítico</th></tr>
            @foreach($c->attacks as $a)
                <tr>
                    <td>{{ $a['name'] }}</td>
                    <td>{{ $a['attack_display'] }}</td>
                    <td>{{ $a['damage'] }} <span class="muted">{{ $a['damage_type'] }}</span></td>
                    <td>{{ $a['threat_range'] }} {{ $a['crit_multiplier'] }}</td>
                </tr>
            @endforeach
        </table>
        @else <div class="muted">Nenhuma arma.</div> @endif

        {{-- Magias --}}
        @if($c->characterClass && $c->characterClass->is_spellcaster)
            <h2>Magias @if($c->spell_dc)<span class="pill">CD {{ $c->spell_dc['value'] }}</span>@endif</h2>
            @if(count($c->spells ?? []))
            <table class="lined">
                <tr><th>Magia</th><th>PM</th></tr>
                @foreach($c->spells as $sp)
                    <tr><td>{{ $sp['name'] }}</td><td>{{ $sp['mp_cost'] ?? '—' }}</td></tr>
                @endforeach
            </table>
            @else <div class="muted">Nenhuma magia conhecida.</div> @endif
        @endif
    </td>
    </tr></table>

    {{-- Poderes --}}
    <h2>Poderes e Habilidades</h2>
    <table class="lined">
        @foreach($c->racial_powers as $rp)
            <tr><td style="width:28%"><b>{{ $rp['name'] }}</b> <span class="tag">Raça</span></td><td>{{ $rp['description'] }}</td></tr>
        @endforeach
        @foreach($c->powers ?? [] as $p)
            <tr>
                <td style="width:28%"><b>{{ $p['name'] }}</b></td>
                <td>{{ $p['description'] ?? '' }}@if(!empty($p['notes']))<br><i class="muted">Nota: {{ $p['notes'] }}</i>@endif</td>
            </tr>
        @endforeach
    </table>

    {{-- Inventário --}}
    <h2>Inventário
        <span class="pill">Carga {{ $c->inventory['used_load'] }}/{{ $c->inventory['max_load'] }} — {{ ucfirst($c->inventory['status']) }}</span>
    </h2>
    <table class="lined">
        <tr><th>Item</th><th>Qtd.</th><th>Espaços</th><th>Estado</th></tr>
        @forelse($c->equipment ?? [] as $item)
            <tr>
                <td>{{ $item['name'] ?? '—' }}</td>
                <td>{{ $item['quantity'] ?? 1 }}</td>
                <td>{{ $item['spaces'] ?? 1 }}</td>
                <td>{{ !empty($item['equipped']) ? 'Equipado' : 'Mochila' }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="muted">Inventário vazio.</td></tr>
        @endforelse
    </table>
    <div class="sub" style="margin-top:6px">
        Tesouro: {{ $c->money_gold }} ouro • {{ $c->money_silver }} prata • {{ $c->money_copper }} cobre
    </div>

</body>
</html>
