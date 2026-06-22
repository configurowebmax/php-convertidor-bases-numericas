<?php
/**
 * Convertidor de Bases Numéricas - Decimal, Binario, Octal, Hexadecimal
 */
header('Content-Type: text/html; charset=utf-8');

$numero = '';
$baseOrigen = 'decimal';
$resultados = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = trim($_POST['numero'] ?? '');
    $baseOrigen = $_POST['base'] ?? 'decimal';

    if ($numero !== '') {
        try {
            // Convertir a decimal primero según la base de origen
            switch ($baseOrigen) {
                case 'decimal':
                    if (!preg_match('/^-?\d+$/', $numero)) throw new Exception('Número decimal inválido');
                    $decimal = intval($numero);
                    break;
                case 'binario':
                    if (!preg_match('/^[01]+$/', $numero)) throw new Exception('Número binario inválido (solo 0 y 1)');
                    $decimal = bindec($numero);
                    break;
                case 'octal':
                    if (!preg_match('/^[0-7]+$/', $numero)) throw new Exception('Número octal inválido (solo 0-7)');
                    $decimal = octdec($numero);
                    break;
                case 'hexadecimal':
                    if (!preg_match('/^[0-9a-fA-F]+$/', $numero)) throw new Exception('Número hexadecimal inválido (solo 0-9, A-F)');
                    $decimal = hexdec($numero);
                    break;
                default:
                    throw new Exception('Base no soportada');
            }

            $resultados = [
                'Decimal (Base 10)'     => strval($decimal),
                'Binario (Base 2)'      => decbin($decimal),
                'Octal (Base 8)'        => decoct($decimal),
                'Hexadecimal (Base 16)' => strtoupper(dechex($decimal)),
            ];
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Convertidor de Bases Numéricas Online | ConfiguroWeb</title>
<meta name="description" content="Convierte números entre decimal, binario, octal y hexadecimal online gratis. Herramienta rápida y precisa de ConfiguroWeb.">
<meta name="keywords" content="convertidor bases numéricas, decimal a binario, hexadecimal, octal, conversión numérica">
<meta property="og:type" content="website">
<meta property="og:title" content="Convertidor de Bases Numéricas Online">
<meta property="og:description" content="Convierte números entre decimal, binario, octal y hexadecimal online gratis.">
<link rel="canonical" href="https://demoscweb.com/github/php-convertidor-bases-numericas/">
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"WebApplication","name":"Convertidor de Bases Numéricas","applicationCategory":"UtilitiesApplication","operatingSystem":"Any","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"author":{"@type":"Person","name":"ConfiguroWeb","url":"https://configuroweb.com"}}
</script>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
  <h1>🔢 Convertidor de Bases Numéricas</h1>
  <p class="subtitle">Decimal · Binario · Octal · Hexadecimal</p>
</header>
<main>
  <form method="POST">
    <label for="numero">Número a convertir</label>
    <input type="text" name="numero" id="numero" value="<?php echo htmlspecialchars($numero); ?>" placeholder="Ej. 255, 11111111, FF" required>

    <label for="base">Base de origen</label>
    <select name="base" id="base">
      <option value="decimal" <?php if($baseOrigen==='decimal') echo 'selected'; ?>>Decimal (Base 10)</option>
      <option value="binario" <?php if($baseOrigen==='binario') echo 'selected'; ?>>Binario (Base 2)</option>
      <option value="octal" <?php if($baseOrigen==='octal') echo 'selected'; ?>>Octal (Base 8)</option>
      <option value="hexadecimal" <?php if($baseOrigen==='hexadecimal') echo 'selected'; ?>>Hexadecimal (Base 16)</option>
    </select>

    <button type="submit" class="btn-primary">🔄 Convertir</button>
  </form>

  <?php if ($error): ?>
  <div style="margin-top:1.5rem;padding:1rem;background:#7f1d1d;border-radius:var(--radius);color:#fca5a5">
    ⚠️ <?php echo htmlspecialchars($error); ?>
  </div>
  <?php endif; ?>

  <?php if ($resultados): ?>
  <div class="resultados" style="margin-top:1.5rem">
    <h2 style="margin-bottom:1rem;font-size:1.1rem">Resultados de la conversión</h2>
    <?php foreach ($resultados as $base => $valor): ?>
    <div style="display:block;margin-bottom:.8rem;background:var(--surface);padding:1rem;border-radius:var(--radius)">
      <span class="etiqueta" style="font-size:.8rem;text-transform:uppercase;opacity:.7;letter-spacing:1px"><?php echo $base; ?></span>
      <code style="display:block;font-size:1.3rem;font-weight:700;margin-top:.3rem;color:var(--success);word-break:break-all;font-family:'Cascadia Code',Consolas,monospace"><?php echo htmlspecialchars($valor); ?></code>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <section class="info">
    <h2>¿Cómo funciona?</h2>
    <p>Este convertidor transforma números entre los 4 sistemas numéricos más usados en programación e informática:</p>
    <p><strong>Decimal (Base 10):</strong> Sistema estándar (0-9).</p>
    <p><strong>Binario (Base 2):</strong> Lenguaje de las computadoras (0 y 1).</p>
    <p><strong>Octal (Base 8):</strong> Usado en permisos Unix/Linux (0-7).</p>
    <p><strong>Hexadecimal (Base 16):</strong> Colores CSS, direcciones de memoria (0-F).</p>
    <p class="formula">255₁₀ = 11111111₂ = 377₈ = FF₁₆</p>
  </section>
</main>
<footer>
  <p>Desarrollado por <a href="https://configuroweb.com" target="_blank">ConfiguroWeb</a> ·
     <a href="https://appscweb.com/citas/" target="_blank">Sistema de Citas</a> ·
     <a href="https://appscweb.com/negocios/" target="_blank">Gestión de Negocios</a></p>
  <p>&copy; <?php echo date('Y'); ?> ConfiguroWeb</p>
</footer>
<script src="assets/script.js"></script>
</body>
</html>
