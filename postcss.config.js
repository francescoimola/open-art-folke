import postcssPresetEnv from 'postcss-preset-env';
import autoprefixer from 'autoprefixer';

export default {
  plugins: [
    postcssPresetEnv({
      stage: 2,
      features: {
        'cascade-layers': false,
      },
    }),
    autoprefixer(),
  ],
};
