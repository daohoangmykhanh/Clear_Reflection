import { NbMenuItem } from '@nebular/theme';

export const MENU_ITEMS: NbMenuItem[] = [
  {
    title: 'Dashboard',
    icon: 'home-outline',
    link: '/admin/dashboard',
    home: true,
  },
  {
    title: 'FEATURES',
    group: true,
  },
  {
    title: 'Products',
    icon: 'grid-outline',
    children: [
      {
        title: 'Product List',
        link: '/admin/products/list',
      },
      {
        title: 'Add A Product',
        link: '/admin/products/add',
      },
      {
        title: 'Product Category',
        link: '/admin/products/category',
      },
      {
        title: 'Product Coupon',
        link: '/admin/products/coupon',
      }
    ],
  },
  {
    title: 'Orders',
    icon: 'clipboard-outline',
    children: [
      {
        title: 'Order List',
        link: '/admin/orders/list',
      },
      {
        title: 'Add An Order',
        link: '/admin/orders/add',
      },
    ]
  },
  {
    title: 'Invoices',
    icon: 'checkmark-square-outline',
    link: '/admin/invoices/list',
  },
  {
    title: 'Customers',
    icon: 'person-done-outline',
    link: '/admin/customers/list',
  },
  {
    title: 'Auth',
    icon: 'lock-outline',
    children: [
      {
        title: 'Login',
        link: '/auth/login',
      },
      {
        title: 'Register',
        link: '/auth/register',
      },
      {
        title: 'Request Password',
        link: '/auth/request-password',
      },
      {
        title: 'Reset Password',
        link: '/auth/reset-password',
      },
    ],
  },
];
