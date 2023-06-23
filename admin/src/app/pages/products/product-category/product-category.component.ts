import { Component } from "@angular/core";
import { LocalDataSource } from "ng2-smart-table";
import { SmartTableService } from "../../../@core/services/smart-table.service";
import { Router } from "@angular/router";

@Component({
  selector: "ngx-product-category",
  templateUrl: "./product-category.component.html",
  styleUrls: ["./product-category.component.scss"],
})
export class ProductCategoryComponent {
  // Setting for List layout
  settings = {
    actions: {
      position: "right",
    },
    mode: "external", // when add/edit -> navigate to another url
    columns: {
      id: {
        title: "ID",
        type: "number",
      },
      firstName: {
        title: "First Name",
        type: "string",
      },
      lastName: {
        title: "Last Name",
        type: "string",
      },
      username: {
        title: "Username",
        type: "string",
      },
      email: {
        title: "E-mail",
        type: "string",
      },
      age: {
        title: "Age",
        type: "number",
      },
    },
    add: {
      addButtonContent: '<i class="nb-plus"></i>',
    },
    edit: {
      editButtonContent: '<i class="nb-edit"></i>',
    },
    delete: {
      deleteButtonContent: '<i class="nb-trash"></i>',
      confirmDelete: true,
    },
  };
  images: any[] = [
    { url: "assets/images/camera1.jpg" },
    { url: "assets/images/camera2.jpg" },
    { url: "assets/images/camera3.jpg" },
    { url: "assets/images/camera4.jpg" },
  ];
  source: LocalDataSource = new LocalDataSource();

  constructor(private service: SmartTableService, private router: Router) {
    const data = this.service.getData();
    this.source.load(data);
  }

  onDeleteConfirm(event): void {
    if (window.confirm("Are you sure you want to delete?")) {
      event.confirm.resolve();
    } else {
      event.confirm.reject();
    }
  }

  onCreateProducts(): void {
    this.router.navigate(["/admin/products", "add"]);
  }

  onEditProducts(event: any): void {
    const productId: string = event.data.id;
    this.router.navigate(["/admin/products", "edit", productId]);
  }

  getProductDetails(event: any): void {
    const productId: string = event.data.id;
    this.router.navigate(["/admin/products", "detail", productId]);
  }

  changeCursor(): void {
    const element = document.getElementById("product-table"); // Replace 'myElement' with the ID of your element
    if (element) {
      element.style.cursor = "pointer";
    }
  }
}
