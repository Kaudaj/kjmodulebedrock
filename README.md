<!-- <h1 align="center"><img src="/views/img/logo.png" alt="Module bedrock" width="500"></h1> -->

# Module bedrock for PrestaShop

[![PHP tests](https://github.com/Kaudaj/kjmodulebedrock/actions/workflows/php.yml/badge.svg)](https://github.com/Kaudaj/kjmodulebedrock/actions/workflows/php.yml)
[![GitHub release](https://img.shields.io/github/release/Kaudaj/kjmodulebedrock.svg)](https://GitHub.com/Kaudaj/kjmodulebedrock/releases/)
[![GitHub license](https://img.shields.io/github/license/Kaudaj/kjmodulebedrock)](https://github.com/Kaudaj/kjmodulebedrock/LICENSE.md)

## About

Tired of building module from scratch every time?<br>
Not satisfied with the PrestaShop generator?<br>
Want an up-to-date bedrock to start with?<br>

Consider cloning this repository and start from **kjmodulebedrock**!<br>

You can use it freely to develop and sell your own modules.

## Essential features

- Code quality checking with [GitHub Actions](https://github.com/Kaudaj/kjmodulebedrock/tree/main/.github/workflows) (CI/CD) and [GrumPHP](https://github.com/phpro/grumphp) (Local).
- Assets compilation with [Webpack](https://webpack.js.org/)
- Multistore configuration form

## Usage

### Installation

**Get started**

```bash
git clone https://github.com/Kaudaj/kjmodulebedrock.git

# Then create your own module from it
cp -R kjmodulebedrock yourmodule
cd yourmodule
rm -rf .git
git init
composer install
cd _dev
npm install
```

**Recommended: Automate the process**

Here is a [bash script][create-new-module] to create a new module from kjmodulebedrock. <br>
It uses `fop:module:rename` command from [`fop_console`][fop-console] project to automate the "search/replace occurences" process. It will also link the local repository to your GitHub remote one if it exists.

It's highly recommended to create an alias for the `create-new-module` script in order to use it in all your PrestaShop projects. The instructions are available in this [gist][create-alias]. Replace `<your-command>` by `/path/to/create-new-module.sh` and `your-alias` with whatever you want.<br>
Make sure you are at the root of your PrestaShop environment and run the script like this:

```bash
your-alias PREFIX,ModuleClassName

# Example
ps-new-module KJ,MyModule
```

### Configuration

- `tests/php/.phpstan_bootstrap_config.php`<br>
For GrumPHP: Set PrestaShop installation path for PHPStan task.<br>
Replace default path with the root path of a stable PrestaShop environment.
- `tests/php/.env`<br>
For GrumPHP: Set PHP executables path for syntax checking tasks.<br>
`tests/php/.env.dist` is used as a fallback, filled with Ubuntu default locations.


### Development

Here are some useful commands you could need during your development workflow:

- `composer grum`<br>
Run GrumPHP tasks suite.
- `composer header-stamp`<br>
Add license headers to files.
- `composer autoindex`<br>
Add index files in directories.
- `composer dumpautoload -a`<br>
Update the autoloader when you add new classes in a classmap package (`src` and `tests` folder here).
- `npm run watch`<br>
(in `_dev` folder) Watch for changes in `_dev` folder and build automatically the assets in `views/dist` folder. It's recommended to run it in background, in a dedicated terminal.

## Compatibility

|     |     |
| --- | --- |
| PrestaShop | **>=1.7.8.0** |
| PHP        | **>=7.1** for production and **>=7.3** for development |
| Multishop | :heavy_check_mark: |

## License

[Academic Free License 3.0][afl-3.0].

## Reporting issues

You can [report issues][report-issue] in this very repository.

## Contributing

As it is an open source project, everyone is welcome and even encouraged to contribute with their own improvements!

To contribute in the best way possible, you want to follow the [PrestaShop contribution guidelines][contribution-guidelines].

## Contact

Feel free to contact us by email at info@kaudaj.com.

[report-issue]: https://github.com/Kaudaj/kjmodulebedrock/issues/new/choose
[prestashop]: https://www.prestashop.com/
[contribution-guidelines]: https://devdocs.prestashop.com/1.7/contribute/contribution-guidelines/project-modules/
[afl-3.0]: https://opensource.org/licenses/AFL-3.0
[fop-console]: https://github.com/friends-of-presta/fop_console
[create-new-module]: https://gist.github.com/tom-combet/dd963b5445bbc05d2290ee1300b72ccd
[create-alias]: https://gist.github.com/tom-combet/cf416de07a615c000a69da5ea44b1e86
