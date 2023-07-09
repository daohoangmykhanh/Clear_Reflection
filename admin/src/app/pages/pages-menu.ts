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
    expanded: true,
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
      },
      {
        title: 'Product Style & Shape',
        link: '/admin/products/style-n-shape',
      }
    ],
  },
  {
    title: 'Orders',
    icon: 'clipboard-outline',
    expanded: true,
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
    ],
  },
];
