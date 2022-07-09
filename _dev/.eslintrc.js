module.exports = {
  root: true,
  env: {
    node: true,
    browser: true,
  },
  extends: ['prestashop'],
  parserOptions: {
    ecmaVersion: 2021,
    parser: '@babel/eslint-parser',
    requireConfigFile: false,
  },
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
  },
  plugins: ['prettier'],
};
