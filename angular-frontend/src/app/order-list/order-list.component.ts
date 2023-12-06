// order-list.component.ts

import { Component, OnInit } from '@angular/core';
import { OrderService } from '../order.service';

@Component({
  selector: 'app-order-list',
  templateUrl: './order-list.component.html',
  styleUrls: ['./order-list.component.css']
})
export class OrderListComponent implements OnInit {
  orders: any[] = [];
  currentPage = 1;
  itemsPerPage = 10;
  searchTerm: string = '';
  searchBy: string = 'customer'; // Valor padrão
  selectedFile: File | null = null;

  errorMessage: string = '';

  constructor(private orderService: OrderService) {}

  ngOnInit() {
    this.loadOrders();
  }

  loadOrders() {
    this.orderService.getOrders().subscribe({
      next: (data) => {
        this.orders = data;
      },
      error: (error) => {
        console.error('Error loading orders', error);
        this.errorMessage = 'Failed to load orders. Please try again later.';
      }
    });
  }

  cancelOrder(orderId: number): void {
    // Implementar a lógica para cancelar um pedido no backend
    this.orderService.cancelOrder(orderId).subscribe(
      () => {
        console.log('Order canceled successfully');
        this.loadOrders(); // Atualiza a lista após o cancelamento
      },
      error => {
        console.error('Error canceling order', error);
      }
    );
  }

  searchOrders(): void {
    // Implementar a lógica para pesquisar pedidos no backend com base no searchTerm
    this.orderService.searchOrders(this.searchTerm, this.searchBy).subscribe(
      (data: any[]) => {
        this.orders = data;
      },
      error => {
        console.error('Error searching orders', error);
      }
    );
  }

  getTotalPages(): number {
    return Math.ceil(this.orders.length / this.itemsPerPage);
  }

  onFileSelected(event: any): void {
    this.selectedFile = event.target.files[0];
  }

  uploadOrders(): void {
    if (this.selectedFile) {
      this.orderService.uploadOrders(this.selectedFile).subscribe(
        () => {
          console.log('Orders uploaded successfully');
          // Can add additional logic after upload
        },
        error => {
          console.error('Error uploading orders', error);
        }
      );
    }
  }
}
