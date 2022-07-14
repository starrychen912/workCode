import i18n from "../locales";
export default function loadComponent(app) {
  console.log(i18n);
  app.use(i18n);
}
