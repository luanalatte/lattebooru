let
  nixpkgs = fetchTarball "https://github.com/NixOS/nixpkgs/tarball/nixpkgs-24.05-darwin";
  pkgs = import nixpkgs { config = {}; overlays = []; };
in

pkgs.mkShellNoCC {
  packages = let
    php = pkgs.php82.buildEnv {
      extensions = ({ all, ... }: with all; [
        ctype
        curl
        dom
        fileinfo
        filter
        mbstring
        openssl
        pdo
        session
        tokenizer
        xmlwriter
        intl
        imagick
        pdo_sqlite
      ]);
      extraConfig = "upload_max_filesize=30M";
    };
  in [
    php
    php.packages.composer
    pkgs.imagemagick
    pkgs.pnpm
  ];
}
